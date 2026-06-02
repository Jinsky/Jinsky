<?php
require_once 'includes/functions.php';
$page_title = "Hasil Diagnosa";
include 'includes/header.php';

if (isset($_GET['mock'])) {
    $id_penyakit_str = $_GET['id_penyakit'] ?? '';
    $disease_ids = explode(',', $id_penyakit_str);
    $primary_disease = get_penyakit_by_id($pdo, $disease_ids[0]);

    // Mock other diseases for UI display
    $other_matches = [];
    for ($i = 1; $i < count($disease_ids); $i++) {
        $p = get_penyakit_by_id($pdo, $disease_ids[$i]);
        if ($p) $other_matches[] = $p;
    }

    $confidence = $_GET['confidence'] ?? 0;
    $selected_gejala_ids = explode(',', $_GET['gejala'] ?? '');
} else {
    $id_diagnosa = $_GET['id'] ?? 0;
    $riwayat = get_diagnosa_by_id($pdo, $id_diagnosa);
    if (!$riwayat) {
        header("Location: konsultasi.php");
        exit;
    }

    $disease_ids = explode(',', $riwayat['id_penyakit']);
    $primary_disease = get_penyakit_by_id($pdo, $disease_ids[0]);

    $other_matches = [];
    for ($i = 1; $i < count($disease_ids); $i++) {
        $p = get_penyakit_by_id($pdo, $disease_ids[$i]);
        if ($p) $other_matches[] = $p;
    }

    $confidence = $riwayat['confidence'];
    $selected_gejala_ids = explode(',', $riwayat['gejala_terpilih']);
}

$all_gejala = get_all_gejala($pdo);
$gejala_names = [];
foreach ($all_gejala as $g) {
    if (in_array($g['id_gejala'], $selected_gejala_ids)) {
        $gejala_names[] = $g['nama'];
    }
}
?>

<main class="pt-24 min-h-screen bg-surface-container-lowest">
    <div class="max-w-5xl mx-auto px-8 pb-20">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-primary font-headline mb-4">Hasil Analisis Medis</h1>
            <p class="text-xl text-on-surface-variant font-body">Berdasarkan gejala yang dilaporkan, berikut adalah hasil diagnosa sistem pakar.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Main Result -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Disease Result Card -->
                <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 overflow-hidden border border-outline-variant/30">
                    <div class="bg-primary p-10 text-on-primary">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="material-symbols-outlined text-4xl">verified</span>
                            <span class="font-bold font-label uppercase tracking-widest text-sm opacity-80">Diagnosa Utama</span>
                        </div>
                        <h2 class="text-4xl font-bold font-headline mb-4"><?= $primary_disease['nama'] ?? 'Tidak Terdeteksi' ?></h2>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-3 bg-white/20 rounded-full overflow-hidden">
                                <div class="h-full bg-secondary shadow-[0_0_12px_rgba(18,106,99,0.8)]" style="width: <?= $confidence ?>%"></div>
                            </div>
                            <span class="font-bold text-xl font-label"><?= $confidence ?>%</span>
                        </div>
                        <p class="text-xs uppercase tracking-[0.2em] font-bold mt-2 opacity-70">Tingkat Kecocokan</p>
                    </div>

                    <div class="p-10 space-y-8">
                        <div>
                            <h3 class="text-xl font-bold text-primary font-headline mb-4 flex items-center gap-3">
                                <span class="material-symbols-outlined text-secondary">info</span>
                                Deskripsi Klinis
                            </h3>
                            <p class="text-on-surface-variant font-body leading-relaxed"><?= $primary_disease['deskripsi'] ?? 'N/A' ?></p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-outline-variant/20">
                            <div>
                                <h4 class="text-lg font-bold text-primary font-headline mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-sm">medical_services</span>
                                    Langkah Pengobatan
                                </h4>
                                <div class="text-sm text-on-surface-variant font-body leading-relaxed space-y-2">
                                    <?= isset($primary_disease['solusi']) ? nl2br($primary_disease['solusi']) : 'N/A' ?>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-primary font-headline mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-tertiary text-sm">shield</span>
                                    Pencegahan
                                </h4>
                                <div class="text-sm text-on-surface-variant font-body leading-relaxed space-y-2">
                                    <?= isset($primary_disease['pencegahan']) ? nl2br($primary_disease['pencegahan']) : 'N/A' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Secondary Matches -->
                <?php if (!empty($other_matches)): ?>
                <div class="bg-surface-container-low p-10 rounded-[3rem] border border-outline-variant/30">
                    <h3 class="text-xl font-bold text-primary font-headline mb-6">Kemungkinan Penyakit Lain</h3>
                    <div class="space-y-4">
                        <?php foreach($other_matches as $other): ?>
                        <div class="bg-white p-6 rounded-2xl border border-outline-variant/30 flex items-center justify-between group hover:border-primary/30 transition-all">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full bg-primary/5 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">clinical_notes</span>
                                </div>
                                <span class="font-bold text-primary"><?= $other['nama'] ?></span>
                            </div>
                            <a href="detail_penyakit.php?id=<?= $other['id_penyakit'] ?>" class="text-xs font-bold text-on-surface-variant group-hover:text-primary transition-colors flex items-center gap-1">
                                Lihat Detail <span class="material-symbols-outlined text-sm">chevron_right</span>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Right: Summary Sidebar -->
            <div class="space-y-8">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-xl shadow-primary/5 border border-outline-variant/30">
                    <h3 class="text-lg font-bold text-primary font-headline mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined">list_alt</span>
                        Gejala yang Dipilih
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach($gejala_names as $name): ?>
                            <span class="px-4 py-2 rounded-xl bg-surface-container text-primary text-sm font-bold font-body"><?= $name ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-primary-container p-8 rounded-[2.5rem] text-primary relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="font-bold mb-4">Butuh Penanganan Lebih Lanjut?</h3>
                        <p class="text-sm opacity-80 mb-6 font-body">Diagnosa ini adalah hasil analisis sistem pakar. Untuk kasus kritis, segera hubungi klinik dokter hewan terdekat.</p>
                        <a href="riwayat.php" class="inline-flex items-center gap-2 font-bold hover:gap-4 transition-all font-label">
                            Lihat Riwayat Diagnosa <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-8xl opacity-10">local_hospital</span>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
