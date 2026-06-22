<?php
require_once 'includes/db.php';

if (!$pdo) {
    echo "Database connection failed. Seed script cannot run.\n";
    exit;
}

echo "Seeding database...\n";

// Clear existing rules and data
$pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
$pdo->exec("TRUNCATE TABLE aturan_detail");
$pdo->exec("TRUNCATE TABLE aturan");
$pdo->exec("TRUNCATE TABLE penyakit");
$pdo->exec("TRUNCATE TABLE gejala");
$pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

// Insert Gejala
$gejala = [
    ['G01', 'Penurunan / Kehilangan nafsu makan'],
    ['G02', 'Diare (non-berdarah, semua warna)'],
    ['G03', 'Diare berdarah'],
    ['G04', 'Keluar air mata berlebihan'],
    ['G05', 'Gangguan pernapasan / Napas tersengal-sengal'],
    ['G06', 'Penurunan / Kehilangan berat badan'],
    ['G07', 'Kematian'],
    ['G08', 'Lemah / Lesu / Kelemahan (umum & otot)'],
    ['G09', 'Bulu kusam'],
    ['G10', 'Penurunan kondisi fisik'],
    ['G11', 'Bersin-bersin'],
    ['G12', 'Hidung berair'],
    ['G13', 'Batuk'],
    ['G14', 'Penurunan produksi telur'],
    ['G15', 'Napas cepat'],
    ['G16', 'Suara pernapasan serak'],
    ['G17', 'Kerutan di belakang leher'],
    ['G18', 'Kehilangan keseimbangan']
];

$stmt = $pdo->prepare("INSERT INTO gejala (id_gejala, nama) VALUES (?, ?)");
foreach ($gejala as $g) {
    $stmt->execute($g);
}
echo "Gejala inserted.\n";

// Insert Penyakit
$penyakit = [
    ['A01', 'Kolera Burung', 'Penyakit infeksi bakteri yang menyerang sistem pencernaan dan pernapasan.', 'Pemberian antibiotik dan perbaikan sanitasi.', 'Vaksinasi kolera dan menjaga kebersihan kandang.'],
    ['A02', 'Paratifus Burung', 'Penyakit bakteri yang menyebabkan gangguan pencernaan parah.', 'Antibiotik sesuai petunjuk dokter hewan.', 'Pemberian pakan bersih dan karantina burung baru.'],
    ['A03', 'Cacingan (Cacing Usus)', 'Infeksi cacing parasit di dalam saluran pencernaan.', 'Pemberian obat cacing secara rutin.', 'Menjaga kebersihan lantai kandang.'],
    ['A04', 'Koksidiosis', 'Penyakit parasit protozoa yang menyerang usus.', 'Pemberian obat antikoksidia.', 'Menjaga kondisi kandang tetap kering.'],
    ['A05', 'Snot (Rhinotracheitis)', 'Penyakit pernapasan menular pada unggas.', 'Antibiotik dan vitamin untuk meningkatkan daya tahan.', 'Menghindari kelembapan tinggi dan sirkulasi udara buruk.'],
    ['A06', 'Batuk Burung', 'Gangguan pernapasan yang ditandai dengan batuk dan bersin.', 'Obat pernapasan dan lingkungan yang hangat.', 'Menghindari debu dan polusi udara di sekitar kandang.'],
    ['A07', 'Tetelo', 'Penyakit viral saraf yang sangat menular.', 'Dukungan vitamin dan nutrisi, isolasi burung sakit.', 'Vaksinasi rutin ND (Newcastle Disease).']
];

$stmt = $pdo->prepare("INSERT INTO penyakit (id_penyakit, nama, deskripsi, solusi, pencegahan) VALUES (?, ?, ?, ?, ?)");
foreach ($penyakit as $p) {
    $stmt->execute($p);
}
echo "Penyakit inserted.\n";

// Insert Aturan
$aturan = [
    ['R01', 'A01'],
    ['R02', 'A02'],
    ['R03a', 'A03'],
    ['R03b', 'A04'],
    ['R04a', 'A03'],
    ['R04b', 'A04'],
    ['R05', 'A05'],
    ['R06', 'A06'],
    ['R07', 'A07']
];

$stmt = $pdo->prepare("INSERT INTO aturan (id_aturan, id_penyakit) VALUES (?, ?)");
foreach ($aturan as $a) {
    $stmt->execute($a);
}
echo "Aturan inserted.\n";

// Insert Aturan Detail
$aturan_detail = [
    // R01: G01, G02, G04, G05, G06, G07
    ['R01', 'G01'], ['R01', 'G02'], ['R01', 'G04'], ['R01', 'G05'], ['R01', 'G06'], ['R01', 'G07'],
    // R02: G01, G02, G06, G07, G08, G09
    ['R02', 'G01'], ['R02', 'G02'], ['R02', 'G06'], ['R02', 'G07'], ['R02', 'G08'], ['R02', 'G09'],
    // R03a: G01, G02, G06, G09, G10
    ['R03a', 'G01'], ['R03a', 'G02'], ['R03a', 'G06'], ['R03a', 'G09'], ['R03a', 'G10'],
    // R03b: G01, G02, G06, G09, G10
    ['R03b', 'G01'], ['R03b', 'G02'], ['R03b', 'G06'], ['R03b', 'G09'], ['R03b', 'G10'],
    // R04a: G01, G03, G06, G07, G08
    ['R04a', 'G01'], ['R04a', 'G03'], ['R04a', 'G06'], ['R04a', 'G07'], ['R04a', 'G08'],
    // R04b: G01, G03, G06, G07, G08
    ['R04b', 'G01'], ['R04b', 'G03'], ['R04b', 'G06'], ['R04b', 'G07'], ['R04b', 'G08'],
    // R05: G01, G08, G11, G12, G13, G14
    ['R05', 'G01'], ['R05', 'G08'], ['R05', 'G11'], ['R05', 'G12'], ['R05', 'G13'], ['R05', 'G14'],
    // R06: G10, G11, G13, G14, G15, G16
    ['R06', 'G10'], ['R06', 'G11'], ['R06', 'G13'], ['R06', 'G14'], ['R06', 'G15'], ['R06', 'G16'],
    // R07: G05, G06, G07, G08, G17, G18
    ['R07', 'G05'], ['R07', 'G06'], ['R07', 'G07'], ['R07', 'G08'], ['R07', 'G17'], ['R07', 'G18']
];

$stmt = $pdo->prepare("INSERT INTO aturan_detail (id_aturan, id_gejala) VALUES (?, ?)");
foreach ($aturan_detail as $ad) {
    $stmt->execute($ad);
}
echo "Aturan Detail inserted.\n";

echo "Seeding complete.\n";
