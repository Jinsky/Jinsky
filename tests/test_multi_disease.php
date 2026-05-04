<?php
require_once __DIR__ . '/../includes/functions.php';

$pdo = null; // Use Mock Mode

echo "Testing get_diagnosa (Mock)...\n";
$diagnoses = get_diagnosa($pdo, ['G14', 'G15']);
if (!empty($diagnoses)) {
    echo "PASS: Diagnoses found\n";
    foreach ($diagnoses as $d) {
        echo "- " . $d['nama'] . " (ID: " . $d['id'] . ")\n";
    }
} else {
    echo "FAIL: No diagnoses found\n";
}

echo "\nTesting save_diagnosa (Mock)...\n";
$res = save_diagnosa($pdo, 'Test User', ['P01', 'P02'], ['G01'], 100);
echo "Result (Expected false since pdo is null): " . ($res === false ? "PASS" : "FAIL") . "\n";

echo "\nTesting get_riwayat (Mock)...\n";
$riwayat = get_riwayat($pdo);
if (!empty($riwayat)) {
    echo "PASS: Riwayat found\n";
    foreach ($riwayat as $r) {
        echo "Patient: " . $r['nama_merpati'] . " | Diseases: " . $r['nama_penyakit'] . "\n";
    }
} else {
    echo "FAIL: No riwayat found\n";
}
