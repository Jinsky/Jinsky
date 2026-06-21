<?php
require_once 'db.php';

/**
 * Track visitor count
 */
function track_visitor($pdo) {
    if (!$pdo) return;
    try {
        $pdo->query("UPDATE pengunjung SET total = total + 1 WHERE id_pengunjung = 1");
    } catch (Exception $e) {}
}

/**
 * Get total visitor count
 */
function get_visitor_count($pdo) {
    if (!$pdo) return 0;
    try {
        return $pdo->query("SELECT total FROM pengunjung WHERE id_pengunjung = 1")->fetchColumn();
    } catch (Exception $e) { return 0; }
}

/**
 * Fetch all symptoms from the database
 */
function get_all_gejala($pdo) {
    if (!$pdo) {
        // Fallback mock data for demonstration if DB is missing
        return [
            ['id_gejala' => 'G01', 'nama' => 'Penurunan nafsu makan, diare berwarna hijau kekuningan, keluar air mata berlebihan, napas tersengal-sengal, kehilangan berat badan, dan kematian.'],
            ['id_gejala' => 'G02', 'nama' => 'Nafsu makan menurun, diare berwarna hijau gelap atau coklat, lesu, bulu kusam, penurunan berat badan, dan kematian.'],
            ['id_gejala' => 'G03', 'nama' => 'Diare, kehilangan nafsu makan, bulu kusam, penurunan berat badan, dan penurunan kondisi fisik.'],
            ['id_gejala' => 'G04', 'nama' => 'Diare berdarah, lemah, nafsu makan menurun, penurunan berat badan, dan kematian.'],
            ['id_gejala' => 'G05', 'nama' => 'Bersin-bersin, hidung berair, batuk, kehilangan nafsu makan, kelemahan, dan penurunan produksi telur.'],
            ['id_gejala' => 'G06', 'nama' => 'Batuk, bersin-bersin, nafas cepat, suara pernafasan serak, penurunan kondisi fisik, dan penurunan produksi telur.'],
            ['id_gejala' => 'G07', 'nama' => 'Kelemahan otot, kerutan di belakang leher, gangguan pernapasan, berat badan turun, kehilangan keseimbangan, dan kematian.']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM gejala ORDER BY id_gejala ASC");
    return $stmt->fetchAll();
}

/**
 * Weighted Diagnostic Algorithm
 * Returns an array of matched diseases based on selected symptoms
 */
function get_diagnosa($pdo, $selected_gejala) {
    if (empty($selected_gejala)) return [];

    if (!$pdo) {
        // Simple mock logic for demo based on new rules
        $rules = [
            'P01' => ['G01'],
            'P02' => ['G02'],
            'P03' => ['G03'],
            'P04' => ['G04'],
            'P05' => ['G05'],
            'P06' => ['G06'],
            'P07' => ['G07'],
        ];

        $results = [];
        $penyakit_list = get_all_penyakit(null);

        foreach ($rules as $pid => $required_gejala) {
            $matched = array_intersect($required_gejala, $selected_gejala);
            if (!empty($matched)) {
                $confidence = (count($matched) / count($required_gejala)) * 100;
                foreach ($penyakit_list as $p) {
                    if ($p['id_penyakit'] === $pid) {
                        $p['confidence'] = round($confidence, 2);
                        $results[] = $p;
                    }
                }
            }
        }

        usort($results, function($a, $b) {
            return $b['confidence'] <=> $a['confidence'];
        });

        return $results;
    }

    // Fetch all rules and their associated symptoms
    $stmt = $pdo->query("
        SELECT a.id_penyakit, ad.id_gejala
        FROM aturan a
        JOIN aturan_detail ad ON a.id_aturan = ad.id_aturan
    ");
    $rules_raw = $stmt->fetchAll();

    $disease_matches = []; // [id_penyakit => [gejala_terpilih]]
    $disease_total_symptoms = []; // [id_penyakit => total_count]

    foreach ($rules_raw as $row) {
        $pid = $row['id_penyakit'];
        $gid = $row['id_gejala'];

        if (!isset($disease_total_symptoms[$pid])) {
            $disease_total_symptoms[$pid] = 0;
        }
        $disease_total_symptoms[$pid]++;

        if (in_array($gid, $selected_gejala)) {
            if (!isset($disease_matches[$pid])) {
                $disease_matches[$pid] = [];
            }
            if (!in_array($gid, $disease_matches[$pid])) {
                $disease_matches[$pid][] = $gid;
            }
        }
    }

    if (empty($disease_matches)) return [];

    $results = [];
    foreach ($disease_matches as $pid => $matched_gejala) {
        $count = count($matched_gejala);
        $total = $disease_total_symptoms[$pid];
        $confidence = round(($count / $total) * 100, 2);

        $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id_penyakit = ?");
        $stmt->execute([$pid]);
        $penyakit = $stmt->fetch();

        if ($penyakit) {
            $penyakit['confidence'] = $confidence;
            $results[] = $penyakit;
        }
    }

    // Sort by confidence descending
    usort($results, function($a, $b) {
        return $b['confidence'] <=> $a['confidence'];
    });

    return $results;
}

/**
 * Save diagnosis result to history
 */
function save_diagnosa($pdo, $nama_merpati, $id_penyakit, $gejala_terpilih, $confidence) {
    if (!$pdo) return false;
    $stmt = $pdo->prepare("INSERT INTO diagnosa (nama_merpati, id_penyakit, gejala_terpilih, confidence) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nama_merpati, $id_penyakit, implode(',', $gejala_terpilih), $confidence]);
}

/**
 * Get diagnosis history with search and filter
 */
function get_riwayat($pdo, $search = '', $id_penyakit = '') {
    if (!$pdo) {
        $mock_data = [
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G01'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'P07', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G07']
        ];

        if ($search) {
            $mock_data = array_filter($mock_data, function($r) use ($search) {
                return strpos(strtolower($r['nama_merpati']), strtolower($search)) !== false ||
                       strpos(strtolower($r['nama_penyakit']), strtolower($search)) !== false;
            });
        }

        if ($id_penyakit) {
            $mock_data = array_filter($mock_data, function($r) use ($id_penyakit) {
                return $r['id_penyakit'] == $id_penyakit;
            });
        }

        return array_values($mock_data);
    }

    $query = "
        SELECT d.*, p.nama as nama_penyakit
        FROM diagnosa d
        LEFT JOIN penyakit p ON d.id_penyakit = p.id_penyakit
        WHERE 1=1
    ";
    $params = [];

    if (!empty($search)) {
        $query .= " AND (d.nama_merpati LIKE ? OR p.nama LIKE ?)";
        $params[] = "%$search%";
        $params[] = "%$search%";
    }

    if (!empty($id_penyakit)) {
        $query .= " AND d.id_penyakit = ?";
        $params[] = $id_penyakit;
    }

    $query .= " ORDER BY d.tanggal DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

/**
 * Get specific diagnosis by ID
 */
function get_diagnosa_by_id($pdo, $id) {
    if (!$pdo) {
        // Fallback for mock data
        $mock_data = [
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G01'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'P07', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G07']
        ];
        foreach ($mock_data as $r) {
            if ($r['id_diagnosa'] == $id) return $r;
        }
        return null;
    }
    $stmt = $pdo->prepare("SELECT * FROM diagnosa WHERE id_diagnosa = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/**
 * Get all diseases for catalog
 */
function get_all_penyakit($pdo) {
    if (!$pdo) {
        return [
            ['id_penyakit' => 'P01', 'nama' => 'Kolera Burung', 'deskripsi' => 'Penyakit infeksi bakteri yang menyerang sistem pencernaan dan pernapasan.', 'solusi' => 'Pemberian antibiotik dan perbaikan sanitasi.', 'pencegahan' => 'Vaksinasi kolera dan menjaga kebersihan kandang.'],
            ['id_penyakit' => 'P02', 'nama' => 'Paratifus Burung', 'deskripsi' => 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'solusi' => 'Antibiotik sesuai petunjuk dokter hewan.', 'pencegahan' => 'Pemberian pakan bersih dan karantina burung baru.'],
            ['id_penyakit' => 'P03', 'nama' => 'Cacingan (Cacing Usus)', 'deskripsi' => 'Infeksi cacing parasit di dalam saluran pencernaan.', 'solusi' => 'Pemberian obat cacing secara rutin.', 'pencegahan' => 'Menjaga kebersihan lantai kandang.'],
            ['id_penyakit' => 'P04', 'nama' => 'Koksidiosis', 'deskripsi' => 'Penyakit parasit protozoa yang menyerang usus.', 'solusi' => 'Pemberian obat antikoksidia.', 'pencegahan' => 'Menjaga kondisi kandang tetap kering.'],
            ['id_penyakit' => 'P05', 'nama' => 'Snot (Rhinotracheitis)', 'deskripsi' => 'Penyakit pernapasan menular pada unggas.', 'solusi' => 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'pencegahan' => 'Menghindari kelembapan tinggi dan sirkulasi udara buruk.'],
            ['id_penyakit' => 'P06', 'nama' => 'Batuk Burung', 'deskripsi' => 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'solusi' => 'Obat pernapasan dan lingkungan yang hangat.', 'pencegahan' => 'Menghindari debu dan polusi udara di sekitar kandang.'],
            ['id_penyakit' => 'P07', 'nama' => 'Tetelo', 'deskripsi' => 'Penyakit viral saraf yang sangat menular.', 'solusi' => 'Dukungan vitamin dan nutrisi, isolasi burung sakit.', 'pencegahan' => 'Vaksinasi rutin ND (Newcastle Disease).']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM penyakit ORDER BY id_penyakit ASC");
    return $stmt->fetchAll();
}

/**
 * Get specific disease by ID
 */
function get_penyakit_by_id($pdo, $id) {
    if (!$pdo) {
        $all = get_all_penyakit(null);
        foreach ($all as $p) {
            if ($p['id_penyakit'] === $id) return $p;
        }
        return null;
    }
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id_penyakit = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>
