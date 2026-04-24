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
 * Returns the matched disease based on selected symptoms
 */
function get_diagnosa($pdo, $selected_gejala) {
    if (empty($selected_gejala)) return null;

    if (!$pdo) {
        // Mock logic for demo if DB is missing
        $mock_gejala_p01 = ['G14', 'G15', 'G16'];
        $match_count = count(array_intersect($mock_gejala_p01, $selected_gejala));
        if ($match_count > 0) {
            $penyakit = [
                'id' => 'P01',
                'nama' => 'Newcastle Disease',
                'deskripsi' => 'Penyakit Newcastle (ND) atau yang dikenal dengan nama Tetelo adalah penyakit viral yang sangat menular pada unggas. Gejala yang paling khas adalah gangguan saraf seperti leher berputar (tortikolis) dan kelumpuhan.',
                'solusi' => '1. Isolasi segera burung.\n2. Berikan dukungan vitamin B Kompleks.\n3. Desinfeksi kandang.',
                'pencegahan' => '1. Vaksinasi rutin.\n2. Biosekuriti ketat.',
                'confidence' => round($match_count * 33.33, 2)
            ];
            if ($penyakit['confidence'] > 100) $penyakit['confidence'] = 100;
            return $penyakit;
        }
        return null;
    }

    // Fetch all rules and their associated symptoms with percentages
    $stmt = $pdo->query("
        SELECT a.id as id_aturan, a.id_penyakit, ad.id_gejala, ad.persentase
        FROM aturan a
        JOIN aturan_detail ad ON a.id = ad.id_aturan
    ");
    $rules_raw = $stmt->fetchAll();

    $rule_scores = []; // [id_aturan => ['id_penyakit' => PXX, 'score' => score]]

    foreach ($rules_raw as $row) {
        $aid = $row['id_aturan'];
        if (!isset($rule_scores[$aid])) {
            $rule_scores[$aid] = [
                'id_penyakit' => $row['id_penyakit'],
                'score' => 0
            ];
        }
        if (in_array($row['id_gejala'], $selected_gejala)) {
            $rule_scores[$aid]['score'] += (float)$row['persentase'];
        }
    }

    if (empty($rule_scores)) return null;

    // Find the rule with the highest score
    $max_score = 0;
    $best_penyakit_id = null;

    foreach ($rule_scores as $rule) {
        if ($rule['score'] > $max_score) {
            $max_score = $rule['score'];
            $best_penyakit_id = $rule['id_penyakit'];
        }
    }

    if ($max_score == 0) return null;
    if ($max_score > 100) $max_score = 100;

    $stmt = $pdo->prepare("SELECT * FROM penyakit WHERE id = ?");
    $stmt->execute([$best_penyakit_id]);
    $penyakit = $stmt->fetch();

    if ($penyakit) {
        $penyakit['confidence'] = round($max_score, 2);
        return $penyakit;
    }

    return null;
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
 * Get diagnosis history
 */
function get_riwayat($pdo) {
    if (!$pdo) {
        return [
            ['id' => 1, 'nama_merpati' => 'Merpati Pos A', 'nama_penyakit' => 'Newcastle Disease', 'id_penyakit' => 'P01', 'confidence' => 100, 'tanggal' => date('Y-m-d H:i:s'), 'gejala_terpilih' => 'G14,G15,G16']
        ];
    }
    $stmt = $pdo->query("
        SELECT d.*, p.nama as nama_penyakit
        FROM diagnosa d
        LEFT JOIN penyakit p ON d.id_penyakit = p.id
        ORDER BY d.tanggal DESC
    ");
    return $stmt->fetchAll();
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
