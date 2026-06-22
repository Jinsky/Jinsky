<?php
require_once __DIR__ . '/../includes/functions.php';

// Mock PDO to simulate DB absence
$pdo = null;

echo "--- Testing Mock Mode (Updated Rules v3) ---\n";

// Test 1: Empty symptoms
$res = get_diagnosa($pdo, []);
echo "Test 1 (0 symptoms, expected empty array): " . (empty($res) ? "PASS" : "FAIL") . "\n";

// Test 2: Match A01 with R01 (G01, G02, G04, G05, G06, G07) - Match 6
$res = get_diagnosa($pdo, ['G01', 'G02', 'G04', 'G05', 'G06', 'G07']);
echo "Test 2 (6 symptoms for A01, expected A01 match_count 6): " . (!empty($res) && $res[0]['id_penyakit'] === 'A01' && $res[0]['match_count'] == 6 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

// Test 3: Match A07 with 4 symptoms (G05, G06, G07, G08) - Tinggi threshold
$res = get_diagnosa($pdo, ['G05', 'G06', 'G07', 'G08']);
echo "Test 3 (G05, G06, G07, G08, expected match_count 4): " . (!empty($res) && $res[0]['match_count'] == 4 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Match for " . $res[0]['id_penyakit'] . ": " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

// Test 4: Match A03/A04 specifically with (G09, G10, G01) - Kolera (A01) only has G01 here.
$res = get_diagnosa($pdo, ['G09', 'G10', 'G01']);
echo "Test 4 (G09, G10, G01, expected match_count 3 for A03/A04): " . (!empty($res) && ($res[0]['id_penyakit'] === 'A03' || $res[0]['id_penyakit'] === 'A04') && $res[0]['match_count'] == 3 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

// Test 5: Match A05 with 2 symptoms (G12, G13)
$res = get_diagnosa($pdo, ['G12', 'G13']);
echo "Test 5 (G12, G13, expected match_count 2): " . (!empty($res) && $res[0]['match_count'] == 2 ? "PASS" : "FAIL") . "\n";
if (!empty($res)) {
    echo "Top Match: " . $res[0]['nama'] . " (Match Count: " . $res[0]['match_count'] . ")\n";
}

?>
