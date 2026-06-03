<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB failure or presence
$pdo = null; // Test Mock Mode

echo "--- Testing Mock Mode ---\n";

// Test 1: Empty symptoms
$res = get_diagnosa($pdo, []);
echo "Test 1 (0 symptoms, expected empty array): " . (empty($res) ? "PASS" : "FAIL") . "\n";

// Test 2: Match P01 in mock (Note: mock currently returns fixed array if $pdo is null)
$res = get_diagnosa($pdo, ['G14', 'G15']);
echo "Test 2 (G14, G15, expected P01 as top match): " . (!empty($res) && $res[0]['id'] === 'P01' ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Confidence: " . $res[0]['confidence'] . "%)\n";
}

// Test 3: Multiple results check
echo "Test 3 (Multiple results in mock): " . (count($res) > 1 ? "PASS" : "FAIL") . "\n";

echo "\n--- Testing Logic Aggregation (Local Simulation) ---\n";

function simulate_diagnosa($rules_raw, $selected_gejala) {
    if (empty($selected_gejala)) return [];

    $disease_matches = [];
    foreach ($rules_raw as $row) {
        if (in_array($row['id_gejala'], $selected_gejala)) {
            $pid = $row['id_penyakit'];
            if (!isset($disease_matches[$pid])) $disease_matches[$pid] = [];
            if (!in_array($row['id_gejala'], $disease_matches[$pid])) {
                $disease_matches[$pid][] = $row['id_gejala'];
            }
        }
    }

    $results = [];
    foreach ($disease_matches as $pid => $matched) {
        $count = count($matched);
        $confidence = ($count >= 3) ? 100 : round(($count / 3) * 100, 2);
        $results[] = ['id' => $pid, 'confidence' => $confidence];
    }

    usort($results, function($a, $b) {
        return $b['confidence'] <=> $a['confidence'];
    });

    return $results;
}

$rules = [
    ['id_penyakit' => 'P01', 'id_gejala' => 'G01', 'bobot' => 33.33],
    ['id_penyakit' => 'P01', 'id_gejala' => 'G02', 'bobot' => 33.33],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G01', 'bobot' => 33.33],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G03', 'bobot' => 33.33],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G04', 'bobot' => 33.33],
];

// Case A: Higher P02 (2 symptoms vs 1)
$res = simulate_diagnosa($rules, ['G01', 'G03', 'G04']);
echo "Case A (G01+G03+G04): Top P02=" . (!empty($res) && $res[0]['id'] === 'P02' ? "PASS" : "FAIL") . " (Confidence: " . $res[0]['confidence'] . "%)\n";

// Case B: P01 match
$res = simulate_diagnosa($rules, ['G01', 'G02']);
echo "Case B (G01+G02): Top P01=" . (!empty($res) && $res[0]['id'] === 'P01' ? "PASS" : "FAIL") . " (Confidence: " . $res[0]['confidence'] . "%)\n";
?>
