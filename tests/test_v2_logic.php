<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB absence
$pdo = null;

echo "--- Testing Mock Mode (New Logic) ---\n";

// Test 1: Empty symptoms
$res = get_diagnosa($pdo, []);
echo "Test 1 (0 symptoms, expected empty array): " . (empty($res) ? "PASS" : "FAIL") . "\n";

// Test 2: Match P01
$res = get_diagnosa($pdo, ['G01']);
echo "Test 2 (G01, expected P01 as match): " . (!empty($res) && $res[0]['id_penyakit'] === 'P01' ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Confidence: " . $res[0]['confidence'] . "%)\n";
}

// Test 3: Multiple results (G01 and G02)
$res = get_diagnosa($pdo, ['G01', 'G02']);
echo "Test 3 (G01, G02, expected 2 matches): " . (count($res) === 2 ? "PASS" : "FAIL") . "\n";

echo "\n--- Testing Real DB Logic Aggregation (Simulation) ---\n";

function simulate_new_diagnosa($rules_raw, $selected_gejala) {
    if (empty($selected_gejala)) return [];

    $disease_matches = [];
    $disease_total_symptoms = [];

    foreach ($rules_raw as $row) {
        $pid = $row['id_penyakit'];
        $gid = $row['id_gejala'];

        if (!isset($disease_total_symptoms[$pid])) $disease_total_symptoms[$pid] = 0;
        $disease_total_symptoms[$pid]++;

        if (in_array($gid, $selected_gejala)) {
            if (!isset($disease_matches[$pid])) $disease_matches[$pid] = [];
            $disease_matches[$pid][] = $gid;
        }
    }

    $results = [];
    foreach ($disease_matches as $pid => $matched) {
        $confidence = round((count($matched) / $disease_total_symptoms[$pid]) * 100, 2);
        $results[] = ['id_penyakit' => $pid, 'confidence' => $confidence];
    }

    usort($results, function($a, $b) {
        return $b['confidence'] <=> $a['confidence'];
    });

    return $results;
}

$test_rules = [
    ['id_penyakit' => 'P01', 'id_gejala' => 'G01'],
    ['id_penyakit' => 'P02', 'id_gejala' => 'G02'],
    ['id_penyakit' => 'P03', 'id_gejala' => 'G03'],
];

$res = simulate_new_diagnosa($test_rules, ['G03']);
echo "Case Simulation (G03): Top P03=" . (!empty($res) && $res[0]['id_penyakit'] === 'P03' ? "PASS" : "FAIL") . " (Confidence: " . $res[0]['confidence'] . "%)\n";

?>
