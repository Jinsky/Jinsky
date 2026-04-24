<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB failure or presence
$pdo = null; // Test Mock Mode

echo "--- Testing Mock Mode ---\n";

// Test 1: Less than 2 symptoms
$res = get_diagnosa($pdo, ['G14']);
echo "Test 1 (1 symptom, expected null): " . ($res === null ? "PASS" : "FAIL") . "\n";

// Test 2: Match P01 in mock
$res = get_diagnosa($pdo, ['G14', 'G15']);
echo "Test 2 (G14, G15, expected P01): " . ($res['id'] === 'P01' ? "PASS" : "FAIL") . "\n";
echo "Confidence: " . $res['confidence'] . "%\n";

// Test 3: No match in mock
$res = get_diagnosa($pdo, ['G01', 'G02']);
echo "Test 3 (G01, G02, expected null): " . ($res === null ? "PASS" : "FAIL") . "\n";

echo "\n--- Testing Logic Aggregation (Local Simulation) ---\n";

function simulate_diagnosa($rules_raw, $selected_gejala) {
    if (count($selected_gejala) < 2) return null;
    $scores = [];
    foreach ($rules_raw as $row) {
        if (in_array($row['id_gejala'], $selected_gejala)) {
            if (!isset($scores[$row['id_penyakit']])) $scores[$row['id_penyakit']] = 0;
            $scores[$row['id_penyakit']] += (int)$row['bobot'];
        }
    }
    if (empty($scores)) return null;
    arsort($scores);
    return ['id' => key($scores), 'confidence' => min(100, current($scores))];
}

$rules = [
    ['id_penyakit' => 'P01', 'id_gejala' => 'G01', 'bobot' => 30],
    ['id_penyakit' => 'P01', 'id_gejala' => 'G02', 'bobot' => 40],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G01', 'bobot' => 20],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G03', 'bobot' => 60],
];

// Case A: Higher P01
$res = simulate_diagnosa($rules, ['G01', 'G02']);
echo "Case A (G01+G02): P01=" . ($res['id'] === 'P01' ? "PASS" : "FAIL") . " (Score: " . $res['confidence'] . ")\n";

// Case B: Higher P02
$res = simulate_diagnosa($rules, ['G01', 'G03']);
echo "Case B (G01+G03): P02=" . ($res['id'] === 'P02' ? "PASS" : "FAIL") . " (Score: " . $res['confidence'] . ")\n";
?>
