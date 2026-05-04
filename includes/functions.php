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
function save_diagnosa($pdo, $nama_merpati, $id_penyakit, $gejala_terpilih, $confidence) {
    if (!$pdo) return false;
    // id_penyakit can be an array or string
    $pid_str = is_array($id_penyakit) ? implode(',', $id_penyakit) : $id_penyakit;
    $stmt = $pdo->prepare("INSERT INTO diagnosa (nama_merpati, id_penyakit, gejala_terpilih, confidence) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nama_merpati, $pid_str, implode(',', $gejala_terpilih), $confidence]);
}

/**
 * Get diagnosis history with search and filter
 */
function get_riwayat($pdo, $search = '', $id_penyakit_filter = '') {
    if (!$pdo) {
        $mock_data = [
            ['id' => 1, 'nama_merpati' => 'Merpati Pos A', 'nama_penyakit' => 'Newcastle Disease', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G14,G15,G16'],
            ['id' => 2, 'nama_merpati' => 'Budi', 'nama_penyakit' => 'Trichomoniasis', 'id_penyakit' => 'P02', 'confidence' => 66.67, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G19,G21']
        ];

        if ($search) {
            $mock_data = array_filter($mock_data, function($r) use ($search) {
                return strpos(strtolower($r['nama_merpati']), strtolower($search)) !== false ||
                       strpos(strtolower($r['nama_penyakit']), strtolower($search)) !== false;
            });
        }

        if ($id_penyakit_filter) {
            $mock_data = array_filter($mock_data, function($r) use ($id_penyakit_filter) {
                $pids = explode(',', $r['id_penyakit']);
                return in_array($id_penyakit_filter, $pids);
            });
        }

        return array_values($mock_data);
    }

    $query = "SELECT * FROM diagnosa WHERE 1=1";
    $params = [];

    if (!empty($search)) {
        $query .= " AND nama_merpati LIKE ?";
        $params[] = "%$search%";
    }

    if (!empty($id_penyakit_filter)) {
        $query .= " AND (id_penyakit = ? OR id_penyakit LIKE ? OR id_penyakit LIKE ? OR id_penyakit LIKE ?)";
        $params[] = $id_penyakit_filter;
        $params[] = "$id_penyakit_filter,%";
        $params[] = "%,$id_penyakit_filter";
        $params[] = "%,$id_penyakit_filter,%";
    }

    $query .= " ORDER BY tanggal DESC";

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $rows = $stmt->fetchAll();

    // Avoid N+1 by fetching all diseases at once
    $penyakit_all = get_all_penyakit($pdo);
    $penyakit_map = [];
    foreach ($penyakit_all as $p) {
        $penyakit_map[$p['id']] = $p['nama'];
    }

    $results = [];
    foreach ($rows as $row) {
        $pids = explode(',', $row['id_penyakit']);
        $names = [];
        foreach ($pids as $pid) {
            if (isset($penyakit_map[$pid])) {
                $names[] = $penyakit_map[$pid];
            }
        }
        $row['nama_penyakit'] = implode(', ', $names);

        // Secondary filtering for search term in resolved disease names
        if (!empty($search)) {
            $in_name = strpos(strtolower($row['nama_merpati']), strtolower($search)) !== false;
            $in_disease = strpos(strtolower($row['nama_penyakit']), strtolower($search)) !== false;
            if (!$in_name && !$in_disease) continue;
        }

        $results[] = $row;
    }

    return $results;
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
