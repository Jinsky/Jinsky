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
            ['id_gejala' => 'G01', 'nama' => 'Nafsu makan menurun'],
            ['id_gejala' => 'G02', 'nama' => 'Burung terlihat lesu'],
            ['id_gejala' => 'G03', 'nama' => 'Diare'],
            ['id_gejala' => 'G04', 'nama' => 'Diare berdarah'],
            ['id_gejala' => 'G05', 'nama' => 'Berat badan menurun'],
            ['id_gejala' => 'G06', 'nama' => 'Bulu kusam'],
            ['id_gejala' => 'G07', 'nama' => 'Bulu mengembang'],
            ['id_gejala' => 'G08', 'nama' => 'Mata berair'],
            ['id_gejala' => 'G09', 'nama' => 'Mata bengkak'],
            ['id_gejala' => 'G10', 'nama' => 'Keluar cairan dari hidung'],
            ['id_gejala' => 'G11', 'nama' => 'Bersin'],
            ['id_gejala' => 'G12', 'nama' => 'Batuk'],
            ['id_gejala' => 'G13', 'nama' => 'Napas berbunyi'],
            ['id_gejala' => 'G14', 'nama' => 'Sulit bernapas'],
            ['id_gejala' => 'G15', 'nama' => 'Sayap terkulai'],
            ['id_gejala' => 'G16', 'nama' => 'Sulit berjalan'],
            ['id_gejala' => 'G17', 'nama' => 'Kehilangan keseimbangan'],
            ['id_gejala' => 'G18', 'nama' => 'Kepala gemetar'],
            ['id_gejala' => 'G19', 'nama' => 'Tortikolis (kepala berputar)'],
            ['id_gejala' => 'G20', 'nama' => 'Kelumpuhan'],
            ['id_gejala' => 'G21', 'nama' => 'Luka pada kulit'],
            ['id_gejala' => 'G22', 'nama' => 'Benjolan atau plak di rongga mulut'],
            ['id_gejala' => 'G23', 'nama' => 'Bau mulut'],
            ['id_gejala' => 'G24', 'nama' => 'Sulit menelan makanan'],
            ['id_gejala' => 'G25', 'nama' => 'Kotoran berlendir'],
            ['id_gejala' => 'G26', 'nama' => 'Demam'],
            ['id_gejala' => 'G27', 'nama' => 'Sering minum'],
            ['id_gejala' => 'G28', 'nama' => 'Produksi telur menurun'],
            ['id_gejala' => 'G29', 'nama' => 'Aktivitas menurun'],
            ['id_gejala' => 'G30', 'nama' => 'Kondisi tubuh kurus']
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
        // Simple mock logic for demo
        return [
            [
                'id_penyakit' => 'P01',
                'nama' => 'Newcastle Disease',
                'deskripsi' => 'Penyakit Newcastle (ND) atau yang dikenal dengan nama Tetelo adalah penyakit viral yang sangat menular pada unggas.',
                'solusi' => 'Isolasi, Vitamin B, Desinfeksi.',
                'pencegahan' => 'Vaksinasi, Biosekuriti.',
                'confidence' => 100
            ],
            [
                'id_penyakit' => 'P02',
                'nama' => 'Trichomoniasis',
                'deskripsi' => 'Canker atau Goham caused by protozoa Trichomonas gallinae.',
                'solusi' => 'Obat Ronidazole/Metronidazole.',
                'pencegahan' => 'Kebersihan air minum.',
                'confidence' => 66.67
            ]
        ];
    }

    // Fetch all rules and their associated symptoms
    $stmt = $pdo->query("
        SELECT a.id_penyakit, ad.id_gejala
        FROM aturan a
        JOIN aturan_detail ad ON a.id_aturan = ad.id_aturan
    ");
    $rules_raw = $stmt->fetchAll();

    $disease_matches = []; // [id_penyakit => [gejala_terpilih]]

    foreach ($rules_raw as $row) {
        $pid = $row['id_penyakit'];
        $gid = $row['id_gejala'];
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
        // Requirement: If at least 3 symptoms match, 100% confidence. Otherwise (count/3)*100.
        $confidence = ($count >= 3) ? 100 : round(($count / 3) * 100, 2);

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
            ['id_diagnosa' => 1, 'nama_merpati' => 'Merpati Pos A', 'nama_penyakit' => 'Newcastle Disease', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G14,G15,G16'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Trichomoniasis', 'id_penyakit' => 'P02', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G19,G21']
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
        // Fallback for mock data (ignoring search/filter for simplicity here)
        $mock_data = [
            ['id_diagnosa' => 1, 'nama_merpati' => 'Merpati Pos A', 'nama_penyakit' => 'Newcastle Disease', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G14,G15,G16'],
            ['id_diagnosa' => 2, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Trichomoniasis', 'id_penyakit' => 'P02', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G19,G21']
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
            ['id_penyakit' => 'P01', 'nama' => 'Newcastle Disease', 'deskripsi' => 'Penyakit Newcastle (ND) atau Tetelo adalah penyakit viral sangat menular.', 'solusi' => 'Isolasi, Vitamin B, Desinfeksi.', 'pencegahan' => 'Vaksinasi, Biosekuriti.'],
            ['id_penyakit' => 'P02', 'nama' => 'Trichomoniasis', 'deskripsi' => 'Canker atau Goham caused by protozoa Trichomonas gallinae.', 'solusi' => 'Obat Ronidazole/Metronidazole.', 'pencegahan' => 'Kebersihan air minum.'],
            ['id_penyakit' => 'P03', 'nama' => 'Coccidiosis', 'deskripsi' => 'Parasit usus yang menyebabkan diare berdarah.', 'solusi' => 'Obat anti-koksidia.', 'pencegahan' => 'Kandang kering.']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM penyakit ORDER BY id_penyakit ASC");
    return $stmt->fetchAll();
}

/**
 * Get specific disease by ID
 */
function get_penyakit_by_id($pdo, $id) {
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id_penyakit = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>
