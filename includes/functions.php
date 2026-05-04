<?php
require_once 'db.php';

/**
 * Fetch all symptoms from the database
 */
function get_all_gejala($pdo) {
    if (!$pdo) {
        // Fallback mock data for demonstration if DB is missing
        return [
            ['id' => 'G01', 'nama' => 'Nafsu makan menurun'],
            ['id' => 'G02', 'nama' => 'Burung terlihat lesu'],
            ['id' => 'G03', 'nama' => 'Diare'],
            ['id' => 'G04', 'nama' => 'Diare berdarah'],
            ['id' => 'G05', 'nama' => 'Berat badan menurun'],
            ['id' => 'G06', 'nama' => 'Bulu kusam'],
            ['id' => 'G07', 'nama' => 'Bulu mengembang'],
            ['id' => 'G08', 'nama' => 'Mata berair'],
            ['id' => 'G09', 'nama' => 'Mata bengkak'],
            ['id' => 'G10', 'nama' => 'Keluar cairan dari hidung'],
            ['id' => 'G11', 'nama' => 'Bersin'],
            ['id' => 'G12', 'nama' => 'Batuk'],
            ['id' => 'G13', 'nama' => 'Napas berbunyi'],
            ['id' => 'G14', 'nama' => 'Sulit bernapas'],
            ['id' => 'G15', 'nama' => 'Sayap terkulai'],
            ['id' => 'G16', 'nama' => 'Sulit berjalan'],
            ['id' => 'G17', 'nama' => 'Kehilangan keseimbangan'],
            ['id' => 'G18', 'nama' => 'Kepala gemetar'],
            ['id' => 'G19', 'nama' => 'Tortikolis (kepala berputar)'],
            ['id' => 'G20', 'nama' => 'Kelumpuhan'],
            ['id' => 'G21', 'nama' => 'Luka pada kulit'],
            ['id' => 'G22', 'nama' => 'Benjolan atau plak di rongga mulut'],
            ['id' => 'G23', 'nama' => 'Bau mulut'],
            ['id' => 'G24', 'nama' => 'Sulit menelan makanan'],
            ['id' => 'G25', 'nama' => 'Kotoran berlendir'],
            ['id' => 'G26', 'nama' => 'Demam'],
            ['id' => 'G27', 'nama' => 'Sering minum'],
            ['id' => 'G28', 'nama' => 'Produksi telur menurun'],
            ['id' => 'G29', 'nama' => 'Aktivitas menurun'],
            ['id' => 'G30', 'nama' => 'Kondisi tubuh kurus']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM gejala ORDER BY id ASC");
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
                'id' => 'P01',
                'nama' => 'Newcastle Disease',
                'deskripsi' => 'Penyakit Newcastle (ND) atau yang dikenal dengan nama Tetelo adalah penyakit viral yang sangat menular pada unggas.',
                'solusi' => 'Isolasi, Vitamin B, Desinfeksi.',
                'pencegahan' => 'Vaksinasi, Biosekuriti.',
                'confidence' => 100
            ],
            [
                'id' => 'P02',
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
        JOIN aturan_detail ad ON a.id = ad.id_aturan
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

        $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = ?");
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
function save_diagnosa($pdo, $nama_merpati, $ids_penyakit, $gejala_terpilih, $confidence) {
    if (!$pdo) return false;
    $id_penyakit_str = is_array($ids_penyakit) ? implode(',', $ids_penyakit) : $ids_penyakit;
    $stmt = $pdo->prepare("INSERT INTO diagnosa (nama_merpati, id_penyakit, gejala_terpilih, confidence) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nama_merpati, $id_penyakit_str, implode(',', $gejala_terpilih), $confidence]);
}

/**
 * Get diagnosis history with search and filter
 */
function get_riwayat($pdo, $search = '', $id_penyakit_filter = '') {
    $penyakit_names = [];
    $all_penyakit = get_all_penyakit($pdo);
    foreach ($all_penyakit as $p) {
        $penyakit_names[$p['id']] = $p['nama'];
    }

    if (!$pdo) {
        $mock_data = [
            ['id' => 1, 'nama_merpati' => 'Merpati Pos A', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G14,G15,G16'],
            ['id' => 2, 'nama_merpati' => 'Budi', 'id_penyakit' => 'P02,P03', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G19,G21']
        ];

        foreach ($mock_data as &$r) {
            $ids = explode(',', $r['id_penyakit']);
            $names = [];
            foreach ($ids as $id) {
                if (isset($penyakit_names[$id])) $names[] = $penyakit_names[$id];
            }
            $r['nama_penyakit'] = implode(', ', $names);
        }

        if ($search) {
            $mock_data = array_filter($mock_data, function($r) use ($search) {
                return strpos(strtolower($r['nama_merpati']), strtolower($search)) !== false ||
                       strpos(strtolower($r['nama_penyakit']), strtolower($search)) !== false;
            });
        }

        if ($id_penyakit_filter) {
            $mock_data = array_filter($mock_data, function($r) use ($id_penyakit_filter) {
                return in_array($id_penyakit_filter, explode(',', $r['id_penyakit']));
            });
        }

        return array_values($mock_data);
    }

    $query = "SELECT * FROM diagnosa WHERE 1=1";
    $params = [];

    if (!empty($id_penyakit_filter)) {
        $query .= " AND FIND_IN_SET(?, REPLACE(id_penyakit, ' ', ''))";
        $params[] = $id_penyakit_filter;
    }

    $query .= " ORDER BY tanggal DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    foreach ($rows as &$row) {
        $ids = explode(',', $row['id_penyakit']);
        $names = [];
        foreach ($ids as $id) {
            if (isset($penyakit_names[$id])) $names[] = $penyakit_names[$id];
        }
        $row['nama_penyakit'] = implode(', ', $names);
    }

    if (!empty($search)) {
        $rows = array_filter($rows, function($r) use ($search) {
            return strpos(strtolower($r['nama_merpati']), strtolower($search)) !== false ||
                   strpos(strtolower($r['nama_penyakit']), strtolower($search)) !== false;
        });
    }

    return array_values($rows);
}

/**
 * Get all diseases for catalog
 */
function get_all_penyakit($pdo) {
    if (!$pdo) {
        return [
            ['id' => 'P01', 'nama' => 'Newcastle Disease', 'deskripsi' => 'Penyakit Newcastle (ND) atau Tetelo adalah penyakit viral sangat menular.', 'solusi' => 'Isolasi, Vitamin B, Desinfeksi.', 'pencegahan' => 'Vaksinasi, Biosekuriti.'],
            ['id' => 'P02', 'nama' => 'Trichomoniasis', 'deskripsi' => 'Canker atau Goham caused by protozoa Trichomonas gallinae.', 'solusi' => 'Obat Ronidazole/Metronidazole.', 'pencegahan' => 'Kebersihan air minum.'],
            ['id' => 'P03', 'nama' => 'Coccidiosis', 'deskripsi' => 'Parasit usus yang menyebabkan diare berdarah.', 'solusi' => 'Obat anti-koksidia.', 'pencegahan' => 'Kandang kering.']
        ];
    }
    $stmt = $pdo->query("SELECT * FROM penyakit ORDER BY id ASC");
    return $stmt->fetchAll();
}

/**
 * Get specific disease by ID
 */
function get_penyakit_by_id($pdo, $id) {
    if (!$pdo) return null;
    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
?>
