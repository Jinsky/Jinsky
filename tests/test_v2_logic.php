<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB absence
$pdo = null;

echo "--- Testing Mock Mode (User Provided Rules) ---\n";

// Test 1: Empty symptoms
$res = get_diagnosa($pdo, []);
echo "Test 1 (0 symptoms, expected empty array): " . (empty($res) ? "PASS" : "FAIL") . "\n";

// Test 2: Match A01 with R01 (G01, G02, G04, G05, G06, G07)
// If we provide all 6, confidence should be 100% and Level should be Tinggi
$symptoms_a01 = ['G01', 'G02', 'G04', 'G05', 'G06', 'G07'];
$res = get_diagnosa($pdo, $symptoms_a01);
echo "Test 2 (6 symptoms for A01, expected 100%): " . (!empty($res) && $res[0]['id_penyakit'] === 'A01' && $res[0]['confidence'] == 100 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Conf: " . $res[0]['confidence'] . "%, Level: " . getMatchLevel($res[0]['match_count']) . ")\n";
}

// Test 3: Match A07 with 3 symptoms (G05, G06, G07)
// Rule R07 has 6 symptoms. 3 matches = 50%. Level should be Sedang.
$res = get_diagnosa($pdo, ['G05', 'G06', 'G07']);
echo "Test 3 (3 symptoms for A07, expected Sedang): " . (!empty($res) && getMatchLevel($res[0]['match_count']) === 'Sedang' ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Match for " . $res[0]['id_penyakit'] . ": " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ", Level: " . getMatchLevel($res[0]['match_count']) . ")\n";
}

// Test 4: Conflict between A03 and A04 (R03a and R03b)
// Both have same symptoms: G01, G02, G06, G09, G10
$symptoms_worm_coccid = ['G01', 'G02', 'G06', 'G09', 'G10'];
$res = get_diagnosa($pdo, $symptoms_worm_coccid);
echo "Test 4 (Shared symptoms for A03/A04, expected both matches): " . (count($res) >= 2 && $res[0]['confidence'] == 100 && $res[1]['confidence'] == 100 ? "PASS" : "FAIL") . "\n";
if (count($res) >= 2) {
    echo "Match 1: " . $res[0]['nama'] . " (" . $res[0]['id_penyakit'] . ")\n";
    echo "Match 2: " . $res[1]['nama'] . " (" . $res[1]['id_penyakit'] . ")\n";
}

?>
