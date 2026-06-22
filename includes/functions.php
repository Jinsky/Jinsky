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
            ['id_gejala' => 'G001', 'nama' => 'Penurunan / Kehilangan nafsu makan'],
            ['id_gejala' => 'G002', 'nama' => 'Diare (non-berdarah, semua warna)'],
            ['id_gejala' => 'G003', 'nama' => 'Diare berdarah'],
            ['id_gejala' => 'G004', 'nama' => 'Keluar air mata berlebihan'],
            ['id_gejala' => 'G005', 'nama' => 'Gangguan pernapasan / Napas tersengal-sengal'],
            ['id_gejala' => 'G006', 'nama' => 'Penurunan / Kehilangan berat badan'],
            ['id_gejala' => 'G007', 'nama' => 'Kematian'],
            ['id_gejala' => 'G008', 'nama' => 'Lemah / Lesu / Kelemahan (umum & otot)'],
            ['id_gejala' => 'G009', 'nama' => 'Bulu kusam'],
            ['id_gejala' => 'G010', 'nama' => 'Penurunan kondisi fisik'],
            ['id_gejala' => 'G011', 'nama' => 'Bersin-bersin'],
            ['id_gejala' => 'G012', 'nama' => 'Hidung berair'],
            ['id_gejala' => 'G013', 'nama' => 'Batuk'],
            ['id_gejala' => 'G014', 'nama' => 'Penurunan produksi telur'],
            ['id_gejala' => 'G015', 'nama' => 'Napas cepat'],
            ['id_gejala' => 'G016', 'nama' => 'Suara pernapasan serak'],
            ['id_gejala' => 'G017', 'nama' => 'Kerutan di belakang leher'],
            ['id_gejala' => 'G018', 'nama' => 'Kehilangan keseimbangan']
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

    $rules_raw = [];
    if (!$pdo) {
        $rules_raw = [
            ['id_penyakit' => 'A01', 'id_gejala' => 'G001'], ['id_penyakit' => 'A01', 'id_gejala' => 'G002'], ['id_penyakit' => 'A01', 'id_gejala' => 'G004'],
            ['id_penyakit' => 'A01', 'id_gejala' => 'G001'], ['id_penyakit' => 'A01', 'id_gejala' => 'G005'], ['id_penyakit' => 'A01', 'id_gejala' => 'G006'],
            ['id_penyakit' => 'A01', 'id_gejala' => 'G002'], ['id_penyakit' => 'A01', 'id_gejala' => 'G005'], ['id_penyakit' => 'A01', 'id_gejala' => 'G007'],
            ['id_penyakit' => 'A02', 'id_gejala' => 'G001'], ['id_penyakit' => 'A02', 'id_gejala' => 'G002'], ['id_penyakit' => 'A02', 'id_gejala' => 'G006'],
            ['id_penyakit' => 'A02', 'id_gejala' => 'G002'], ['id_penyakit' => 'A02', 'id_gejala' => 'G007'], ['id_penyakit' => 'A02', 'id_gejala' => 'G008'],
            ['id_penyakit' => 'A02', 'id_gejala' => 'G006'], ['id_penyakit' => 'A02', 'id_gejala' => 'G008'], ['id_penyakit' => 'A02', 'id_gejala' => 'G009'],
            ['id_penyakit' => 'A03', 'id_gejala' => 'G001'], ['id_penyakit' => 'A03', 'id_gejala' => 'G002'], ['id_penyakit' => 'A03', 'id_gejala' => 'G006'],
            ['id_penyakit' => 'A03', 'id_gejala' => 'G002'], ['id_penyakit' => 'A03', 'id_gejala' => 'G006'], ['id_penyakit' => 'A03', 'id_gejala' => 'G009'],
            ['id_penyakit' => 'A03', 'id_gejala' => 'G006'], ['id_penyakit' => 'A03', 'id_gejala' => 'G009'], ['id_penyakit' => 'A03', 'id_gejala' => 'G010'],
            ['id_penyakit' => 'A04', 'id_gejala' => 'G001'], ['id_penyakit' => 'A04', 'id_gejala' => 'G003'], ['id_penyakit' => 'A04', 'id_gejala' => 'G006'],
            ['id_penyakit' => 'A04', 'id_gejala' => 'G003',], ['id_penyakit' => 'A04', 'id_gejala' => 'G007'], ['id_penyakit' => 'A04', 'id_gejala' => 'G008'],
            ['id_penyakit' => 'A04', 'id_gejala' => 'G001',], ['id_penyakit' => 'A04', 'id_gejala' => 'G006'], ['id_penyakit' => 'A04', 'id_gejala' => 'G008'],
            ['id_penyakit' => 'A05', 'id_gejala' => 'G001',], ['id_penyakit' => 'A05', 'id_gejala' => 'G008'], ['id_penyakit' => 'A05', 'id_gejala' => 'G011'],
            ['id_penyakit' => 'A05', 'id_gejala' => 'G011',], ['id_penyakit' => 'A05', 'id_gejala' => 'G012'], ['id_penyakit' => 'A05', 'id_gejala' => 'G013'],
            ['id_penyakit' => 'A05', 'id_gejala' => 'G008',], ['id_penyakit' => 'A05', 'id_gejala' => 'G013'], ['id_penyakit' => 'A05', 'id_gejala' => 'G014'],
            ['id_penyakit' => 'A06', 'id_gejala' => 'G010',], ['id_penyakit' => 'A06', 'id_gejala' => 'G011'], ['id_penyakit' => 'A06', 'id_gejala' => 'G013'],
            ['id_penyakit' => 'A06', 'id_gejala' => 'G013',], ['id_penyakit' => 'A06', 'id_gejala' => 'G014'], ['id_penyakit' => 'A06', 'id_gejala' => 'G015'],
            ['id_penyakit' => 'A06', 'id_gejala' => 'G011',], ['id_penyakit' => 'A06', 'id_gejala' => 'G015'], ['id_penyakit' => 'A06', 'id_gejala' => 'G016'],
            ['id_penyakit' => 'A07', 'id_gejala' => 'G005',], ['id_penyakit' => 'A07', 'id_gejala' => 'G006'], ['id_penyakit' => 'A07', 'id_gejala' => 'G007'],
            ['id_penyakit' => 'A07', 'id_gejala' => 'G006',], ['id_penyakit' => 'A07', 'id_gejala' => 'G008'], ['id_penyakit' => 'A07', 'id_gejala' => 'G017'],
            ['id_penyakit' => 'A07', 'id_gejala' => 'G007',], ['id_penyakit' => 'A07', 'id_gejala' => 'G017'], ['id_penyakit' => 'A07', 'id_gejala' => 'G018']
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
    if (!$pdo) {
        $chunks = array_chunk($rules_raw, 3);
        foreach ($chunks as $chunk) {
            $rules_processed[] = [
                'id_penyakit' => $chunk[0]['id_penyakit'],
                'gejala' => array_column($chunk, 'id_gejala')
            ];
        }
    } else {
        $temp = [];
        foreach ($rules_raw as $row) {
            $temp[$row['id_aturan']]['id_penyakit'] = $row['id_penyakit'];
            $temp[$row['id_aturan']]['gejala'][] = $row['id_gejala'];
        }
        foreach ($temp as $rid => $data) {
            $rules_processed[] = $data;
        }
    }

    $disease_max_matches = []; // [id_penyakit => max_match_count]

    foreach ($rules_processed as $rule) {
        $pid = $rule['id_penyakit'];
        $matched = array_intersect($rule['gejala'], $selected_gejala);
        $count = count($matched);

        if ($count > 0) {
            if (!isset($disease_max_matches[$pid]) || $count > $disease_max_matches[$pid]) {
                $disease_max_matches[$pid] = $count;
            }
        }
    }

    if (empty($disease_max_matches)) return [];

    $results = [];
    foreach ($disease_max_matches as $pid => $match_count) {
        $penyakit = get_penyakit_by_id($pdo, $pid);
        if ($penyakit) {
            $penyakit['match_count'] = $match_count;
            $penyakit['confidence'] = round(($match_count / 3) * 100, 2);
            $results[] = $penyakit;
        }
    }

    // Sort by match_count descending
    usort($results, function($a, $b) {
        return $b['match_count'] <=> $a['match_count'];
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
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'A01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G001,G002,G004'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'A07', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G005,G006']
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
            ['id_diagnosa' => 1, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Kolera Burung', 'id_penyakit' => 'A01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G001,G002,G004'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Ani', 'nama_penyakit' => 'Tetelo', 'id_penyakit' => 'A07', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G005,G006']
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
            ['id_penyakit' => 'A01', 'nama' => 'Kolera Burung', 'deskripsi' => 'Penyakit infeksi bakteri yang menyerang sistem pencernaan and pernapasan.', 'solusi' => 'Pemberian antibiotik and perbaikan sanitasi.', 'pencegahan' => 'Vaksinasi kolera and menjaga kebersihan kandang.'],
            ['id_penyakit' => 'A02', 'nama' => 'Paratifus Burung', 'deskripsi' => 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'solusi' => 'Antibiotik sesuai petunjuk dokter hewan.', 'pencegahan' => 'Pemberian pakan bersih and karantina burung baru.'],
            ['id_penyakit' => 'A03', 'nama' => 'Cacingan', 'deskripsi' => 'Infeksi cacing parasit di dalam saluran pencernaan.', 'solusi' => 'Pemberian obat cacing secara rutin.', 'pencegahan' => 'Menjaga kebersihan lantai kandang.'],
            ['id_penyakit' => 'A04', 'nama' => 'Koksidiosis', 'deskripsi' => 'Penyakit parasit protozoa yang menyerang usus.', 'solusi' => 'Pemberian obat antikoksidia.', 'pencegahan' => 'Menjaga kondisi kandang tetap kering.'],
            ['id_penyakit' => 'A05', 'nama' => 'Snot (Rhinotracheitis)', 'deskripsi' => 'Penyakit pernapasan menular pada unggas.', 'solusi' => 'Antibiotik and vitamin untuk meningkatkan daya tahan.', 'pencegahan' => 'Menghindari kelembapan tinggi and sirkulasi udara buruk.'],
            ['id_penyakit' => 'A06', 'nama' => 'Batuk Burung', 'deskripsi' => 'Gangguan pernapasan yang ditandai dengan batuk and bersin.', 'solusi' => 'Obat pernapasan and lingkungan yang hangat.', 'pencegahan' => 'Menghindari debu and polusi udara di sekitar kandang.'],
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
