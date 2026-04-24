<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock logic for testing without DB
function test_get_diagnosa_mock($selected_gejala) {
    $rules_raw = [
        ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G14', 'persentase' => 33.33],
        ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G15', 'persentase' => 33.33],
        ['id_aturan' => 'R01', 'id_penyakit' => 'P01', 'id_gejala' => 'G16', 'persentase' => 33.33],
        ['id_aturan' => 'R02', 'id_penyakit' => 'P01', 'id_gejala' => 'G14', 'persentase' => 33.33],
        ['id_aturan' => 'R02', 'id_penyakit' => 'P01', 'id_gejala' => 'G16', 'persentase' => 33.33],
        ['id_aturan' => 'R02', 'id_penyakit' => 'P01', 'id_gejala' => 'G17', 'persentase' => 33.33],
    ];

    $rule_scores = [];
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

    $max_score = 0;
    $best_penyakit_id = null;
    foreach ($rule_scores as $rule) {
        if ($rule['score'] > $max_score) {
            $max_score = $rule['score'];
            $best_penyakit_id = $rule['id_penyakit'];
        }
    }
    return ['id' => $best_penyakit_id, 'confidence' => round($max_score, 2)];
}

// Test Case 1: 1 symptom (G14)
$res1 = test_get_diagnosa_mock(['G14']);
echo "Test 1 (1 symptom): " . ($res1['confidence'] == 33.33 ? "PASS" : "FAIL (" . $res1['confidence'] . ")") . "\n";

// Test Case 2: 2 symptoms (G14, G15)
$res2 = test_get_diagnosa_mock(['G14', 'G15']);
echo "Test 2 (2 symptoms): " . ($res2['confidence'] == 66.66 ? "PASS" : "FAIL (" . $res2['confidence'] . ")") . "\n";

// Test Case 3: 3 symptoms (G14, G15, G16)
$res3 = test_get_diagnosa_mock(['G14', 'G15', 'G16']);
echo "Test 3 (3 symptoms): " . ($res3['confidence'] == 99.99 ? "PASS" : "FAIL (" . $res3['confidence'] . ")") . "\n";

// Test Case 4: Extra symptoms
$res4 = test_get_diagnosa_mock(['G14', 'G15', 'G16', 'G17']);
echo "Test 4 (Extra symptoms): " . ($res4['confidence'] == 99.99 ? "PASS" : "FAIL (" . $res4['confidence'] . ")") . "\n";
?>
