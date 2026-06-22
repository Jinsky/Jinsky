<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB absence
$pdo = null;

echo "--- Testing Mock Mode (Updated Rules) ---\n";

// Test 1: Empty symptoms
$res = get_diagnosa($pdo, []);
echo "Test 1 (0 symptoms, expected empty array): " . (empty($res) ? "PASS" : "FAIL") . "\n";

// Test 2: Match A01 with R01 (G01, G02, G04)
$res = get_diagnosa($pdo, ['G01', 'G02', 'G04']);
echo "Test 2 (G01, G02, G04, expected A01 as match with 3): " . (!empty($res) && $res[0]['id_penyakit'] === 'A01' && $res[0]['match_count'] == 3 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

// Test 3: Match A07 with 2 symptoms (G05, G06)
$res = get_diagnosa($pdo, ['G05', 'G06']);
echo "Test 3 (G05, G06, expected match_count 2): " . (!empty($res) && $res[0]['match_count'] == 2 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Match for " . $res[0]['id_penyakit'] . ": " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

// Test 4: All symptoms for A03 (R07: G01, G02, G06; R08: G02, G06, G09; R09: G06, G09, G10)
$res = get_diagnosa($pdo, ['G06', 'G09', 'G10']);
echo "Test 4 (G06, G09, G10, expected A03): " . (!empty($res) && $res[0]['id_penyakit'] === 'A03' && $res[0]['match_count'] == 3 ? "PASS" : "FAIL") . "\n";

?>
