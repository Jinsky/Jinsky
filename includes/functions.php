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
        return [
            ['id_gejala' => 'G01', 'nama' => 'Penurunan / Kehilangan nafsu makan'],
            ['id_gejala' => 'G02', 'nama' => 'Diare (non-berdarah, semua warna)'],
            ['id_gejala' => 'G03', 'nama' => 'Diare berdarah'],
            ['id_gejala' => 'G04', 'nama' => 'Keluar air mata berlebihan'],
            ['id_gejala' => 'G05', 'nama' => 'Gangguan pernapasan / Napas tersengal-sengal'],
            ['id_gejala' => 'G06', 'nama' => 'Penurunan / Kehilangan berat badan'],
            ['id_gejala' => 'G07', 'nama' => 'Kematian'],
            ['id_gejala' => 'G08', 'nama' => 'Lemah / Lesu / Kelemahan'],
            ['id_gejala' => 'G09', 'nama' => 'Bulu kusam'],
            ['id_gejala' => 'G10', 'nama' => 'Penurunan kondisi fisik'],
            ['id_gejala' => 'G11', 'nama' => 'Bersin-bersin'],
            ['id_gejala' => 'G12', 'nama' => 'Hidung berair'],
            ['id_gejala' => 'G13', 'nama' => 'Batuk'],
            ['id_gejala' => 'G14', 'nama' => 'Penurunan produksi telur'],
            ['id_gejala' => 'G15', 'nama' => 'Napas cepat'],
            ['id_gejala' => 'G16', 'nama' => 'Suara pernapasan serak'],
            ['id_gejala' => 'G17', 'nama' => 'Kerutan di belakang leher'],
            ['id_gejala' => 'G18', 'nama' => 'Kehilangan keseimbangan']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM gejala ORDER BY id_gejala ASC");
    return $stmt->fetchAll();
}

/**
 * Helper function to get match level text
 */
function getMatchLevel($count) {
    if ($count >= 4) return 'Tinggi';
    if ($count == 3) return 'Sedang';
    return 'Rendah';
}

/**
 * Weighted Diagnostic Algorithm
 * Returns an array of matched diseases based on selected symptoms
 */
function get_diagnosa($pdo, $selected_gejala) {
    if (empty($selected_gejala)) return [];

    $rules_raw = [];
    if (!$pdo) {
        $rules_raw = [
            // R01: A01
            ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G01'], ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G02'], ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G04'], ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G05'], ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G06'], ['id_aturan' => 'R01', 'id_penyakit' => 'A01', 'id_gejala' => 'G07'],
            // R02: A02
            ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G01'], ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G02'], ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G06'], ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G07'], ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G08'], ['id_aturan' => 'R02', 'id_penyakit' => 'A02', 'id_gejala' => 'G09'],
            // R03a: A03
            ['id_aturan' => 'R03a', 'id_penyakit' => 'A03', 'id_gejala' => 'G01'], ['id_aturan' => 'R03a', 'id_penyakit' => 'A03', 'id_gejala' => 'G02'], ['id_aturan' => 'R03a', 'id_penyakit' => 'A03', 'id_gejala' => 'G06'], ['id_aturan' => 'R03a', 'id_penyakit' => 'A03', 'id_gejala' => 'G09'], ['id_aturan' => 'R03a', 'id_penyakit' => 'A03', 'id_gejala' => 'G10'],
            // R03b: A04
            ['id_aturan' => 'R03b', 'id_penyakit' => 'A04', 'id_gejala' => 'G01'], ['id_aturan' => 'R03b', 'id_penyakit' => 'A04', 'id_gejala' => 'G02'], ['id_aturan' => 'R03b', 'id_penyakit' => 'A04', 'id_gejala' => 'G06'], ['id_aturan' => 'R03b', 'id_penyakit' => 'A04', 'id_gejala' => 'G09'], ['id_aturan' => 'R03b', 'id_penyakit' => 'A04', 'id_gejala' => 'G10'],
            // R04a: A03
            ['id_aturan' => 'R04a', 'id_penyakit' => 'A03', 'id_gejala' => 'G01'], ['id_aturan' => 'R04a', 'id_penyakit' => 'A03', 'id_gejala' => 'G03'], ['id_aturan' => 'R04a', 'id_penyakit' => 'A03', 'id_gejala' => 'G06'], ['id_aturan' => 'R04a', 'id_penyakit' => 'A03', 'id_gejala' => 'G07'], ['id_aturan' => 'R04a', 'id_penyakit' => 'A03', 'id_gejala' => 'G08'],
            // R04b: A04
            ['id_aturan' => 'R04b', 'id_penyakit' => 'A04', 'id_gejala' => 'G01'], ['id_aturan' => 'R04b', 'id_penyakit' => 'A04', 'id_gejala' => 'G03'], ['id_aturan' => 'R04b', 'id_penyakit' => 'A04', 'id_gejala' => 'G06'], ['id_aturan' => 'R04b', 'id_penyakit' => 'A04', 'id_gejala' => 'G07'], ['id_aturan' => 'R04b', 'id_penyakit' => 'A04', 'id_gejala' => 'G08'],
            // R05: A05
            ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G01'], ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G08'], ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G11'], ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G12'], ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G13'], ['id_aturan' => 'R05', 'id_penyakit' => 'A05', 'id_gejala' => 'G14'],
            // R06: A06
            ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G10'], ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G11'], ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G13'], ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G14'], ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G15'], ['id_aturan' => 'R06', 'id_penyakit' => 'A06', 'id_gejala' => 'G16'],
            // R07: A07
            ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G05'], ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G06'], ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G07'], ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G08'], ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G17'], ['id_aturan' => 'R07', 'id_penyakit' => 'A07', 'id_gejala' => 'G18']
        ];
    } else {
        $stmt = $pdo->query("
            SELECT a.id_aturan, a.id_penyakit, ad.id_gejala
            FROM aturan a
            JOIN aturan_detail ad ON a.id_aturan = ad.id_aturan
        ");
        $rules_raw = $stmt->fetchAll();
    }

    $rules_processed = [];
    $temp = [];
    foreach ($rules_raw as $row) {
        $temp[$row['id_aturan']]['id_penyakit'] = $row['id_penyakit'];
        $temp[$row['id_aturan']]['gejala'][] = $row['id_gejala'];
    }
    foreach ($temp as $rid => $data) {
        $rules_processed[] = $data;
    }

    $disease_max_matches = []; // [id_penyakit => ['match_count' => count, 'confidence' => conf]]

    foreach ($rules_processed as $rule) {
        $pid = $rule['id_penyakit'];
        $matched = array_intersect($rule['gejala'], $selected_gejala);
        $count = count($matched);
        $total_rule_gejala = count($rule['gejala']);
        $confidence = round(($count / $total_rule_gejala) * 100, 2);

        if ($count > 0) {
            if (!isset($disease_max_matches[$pid]) || $confidence > $disease_max_matches[$pid]['confidence']) {
                $disease_max_matches[$pid] = [
                    'match_count' => $count,
                    'confidence' => $confidence
                ];
            }
        }
    }

    if (empty($disease_max_matches)) return [];

    $results = [];
    foreach ($disease_max_matches as $pid => $data) {
        $penyakit = get_penyakit_by_id($pdo, $pid);
        if ($penyakit) {
            $penyakit['match_count'] = $data['match_count'];
            $penyakit['confidence'] = $data['confidence'];
            $results[] = $penyakit;
        }
    }

    // Sort by confidence descending, then match_count
    usort($results, function($a, $b) {
        if ($b['confidence'] == $a['confidence']) {
            return $b['match_count'] <=> $a['match_count'];
        }
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
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'A01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G01,G02,G04,G05,G06,G07'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'A07', 'confidence' => 33.33, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G05,G06']
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
        $mock_data = [
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'A01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G01,G02,G04,G05,G06,G07'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'A07', 'confidence' => 33.33, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G05,G06']
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
            ['id_penyakit' => 'A01', 'nama' => 'Kolera Burung', 'deskripsi' => 'Penyakit infeksi bakteri yang menyerang sistem pencernaan dan pernapasan.', 'solusi' => 'Pemberian antibiotik dan perbaikan sanitasi.', 'pencegahan' => 'Vaksinasi kolera dan menjaga kebersihan kandang.'],
            ['id_penyakit' => 'A02', 'nama' => 'Paratifus Burung', 'deskripsi' => 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'solusi' => 'Antibiotik sesuai petunjuk dokter hewan.', 'pencegahan' => 'Pemberian pakan bersih and karantina burung baru.'],
            ['id_penyakit' => 'A03', 'nama' => 'Cacingan (Cacing Usus)', 'deskripsi' => 'Infeksi cacing parasit di dalam saluran pencernaan.', 'solusi' => 'Pemberian obat cacing secara rutin.', 'pencegahan' => 'Menjaga kebersihan lantai kandang.'],
            ['id_penyakit' => 'A04', 'nama' => 'Koksidiosis', 'deskripsi' => 'Penyakit parasit protozoa yang menyerang usus.', 'solusi' => 'Pemberian obat antikoksidia.', 'pencegahan' => 'Menjaga kondisi kandang tetap kering.'],
            ['id_penyakit' => 'A05', 'nama' => 'Snot (Rhinotracheitis)', 'deskripsi' => 'Penyakit pernapasan menular pada unggas.', 'solusi' => 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'pencegahan' => 'Menghindari kelembapan tinggi and sirkulasi udara buruk.'],
            ['id_penyakit' => 'A06', 'nama' => 'Batuk Burung', 'deskripsi' => 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'solusi' => 'Obat pernapasan dan lingkungan yang hangat.', 'pencegahan' => 'Menghindari debu dan polusi udara di sekitar kandang.'],
            ['id_penyakit' => 'A07', 'nama' => 'Tetelo', 'deskripsi' => 'Penyakit viral saraf yang sangat menular.', 'solusi' => 'Dukungan vitamin and nutrisi, isolasi burung sakit.', 'pencegahan' => 'Vaksinasi rutin ND (Newcastle Disease).']
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
