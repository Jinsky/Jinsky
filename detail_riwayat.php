<?php
require_once 'includes/functions.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: riwayat.php');
    exit;
}

// Fetch history record
$record = get_diagnosa_by_id($pdo, $id);

if (!$record) {
    header('Location: riwayat.php');
    exit;
}

$nama_merpati = $record['nama_merpati'];
$selected_gejala = explode(',', $record['gejala_terpilih']);

// Re-run diagnostic engine to get full details (descriptions, other matches)
$diagnoses = get_diagnosa($pdo, $selected_gejala);
$diagnosis = !empty($diagnoses) ? $diagnoses[0] : null;

$page_title = "Detail Riwayat Diagnosa";
include 'includes/header.php';
?>

<main class="pt-32 pb-20 px-8 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <div class="mb-16">
        <span class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full text-sm font-bold tracking-wider uppercase mb-6 inline-block">
            Arsip Diagnosa #<?= htmlspecialchars($id) ?>
        </span>
        <h1 class="font-headline text-5xl md:text-6xl text-primary font-bold tracking-tight mb-6">Detail Hasil Analisis</h1>
        <p class="text-on-surface-variant text-xl max-w-2xl leading-relaxed">
            Nama Pemilik: <span class="font-bold text-on-surface"><?= htmlspecialchars($nama_merpati) ?></span>.
            Pemeriksaan dilakukan pada <span class="font-bold text-on-surface"><?= date('d M Y, H:i', strtotime($record['tanggal'])) ?> WIB</span>.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <?php if ($diagnosis): ?>
            <!-- Results & Insights Area -->
            <div class="lg:col-span-7 space-y-8">
                <div class="bg-surface-container border-l-4 border-primary p-8 rounded-r-xl relative overflow-hidden">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
                        <div>
                            <h2 class="font-headline text-3xl text-primary font-bold mb-2"><?= $diagnosis['nama'] ?></h2>
                            <span class="bg-primary-container text-on-primary-container px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Kecocokan Pola Terkonfirmasi</span>
                        </div>
                        <div class="text-center bg-surface-container-lowest p-6 rounded-2xl shadow-sm border border-outline-variant/10 min-w-[140px]">
                            <p class="text-5xl font-headline font-black text-primary leading-none"><?= $record['confidence'] ?>%</p>
                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mt-2">tingkat kecocokan</p>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest p-6 rounded-xl mb-8 border border-outline-variant/10">
                        <h3 class="font-bold text-on-surface mb-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-lg">info</span>
                            Deskripsi Klinis
                        </h3>
                        <p class="text-on-surface-variant text-sm leading-relaxed">
                            <?= nl2br($diagnosis['deskripsi']) ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="p-6 bg-surface-container-lowest rounded-xl border border-outline-variant/10">
                            <h4 class="font-bold text-primary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">security</span>
                                Langkah Penanganan
                            </h4>
                            <div class="text-xs text-on-surface-variant space-y-2 leading-relaxed">
                                <?= nl2br($diagnosis['solusi']) ?>
                            </div>
                        </div>
                        <div class="p-6 bg-surface-container-lowest rounded-xl border border-outline-variant/10">
                            <h4 class="font-bold text-secondary mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">vaccines</span>
                                Tips Pencegahan
                            </h4>
                            <div class="text-xs text-on-surface-variant space-y-2 leading-relaxed">
                                <?= nl2br($diagnosis['pencegahan']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if (count($diagnoses) > 1): ?>
                    <!-- Other Possible Diseases -->
                    <div class="bg-surface-container-low p-8 rounded-xl">
                        <h3 class="font-headline text-2xl text-primary font-bold mb-6 flex items-center gap-2">
                            <span class="material-symbols-outlined">account_tree</span>
                            Kemungkinan Penyakit Lain
                        </h3>
                        <div class="space-y-4">
                            <?php for ($i = 1; $i < count($diagnoses); $i++): $d = $diagnoses[$i]; ?>
                                <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10 flex justify-between items-center transition-hover hover:shadow-md">
                                    <div>
                                        <h4 class="font-bold text-on-surface"><?= $d['nama'] ?></h4>
                                        <p class="text-xs text-on-surface-variant mt-1 line-clamp-1"><?= strip_tags($d['deskripsi']) ?></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-headline font-bold text-secondary"><?= $d['confidence'] ?>%</span>
                                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Kecocokan</p>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="bg-error-container/20 p-6 rounded-xl border border-error/10">
                    <div class="flex gap-4">
                        <span class="material-symbols-outlined text-error">warning</span>
                        <div>
                            <h4 class="font-bold text-on-error-container">Catatan Historis</h4>
                            <p class="text-sm text-on-error-container opacity-80 mt-1 leading-relaxed">
                                Hasil ini adalah catatan permanen dari diagnosa sistem pakar pada tanggal tersebut. Untuk kondisi kesehatan terkini, selalu lakukan konsultasi ulang jika muncul gejala baru.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar / Details -->
            <div class="lg:col-span-5 space-y-8 sticky top-28">
                <div class="bg-surface-container-low p-8 rounded-xl">
                    <h3 class="font-headline text-xl text-primary mb-6">Gejala yang Dilaporkan</h3>
                    <div class="flex flex-wrap gap-2 mb-8">
                        <?php
                        $gejala_all = get_all_gejala($pdo);
                        foreach ($gejala_all as $g):
                            if (in_array($g['id'], $selected_gejala)):
                        ?>
                                <span class="bg-secondary-container text-on-secondary-container px-3 py-1.5 rounded-full text-xs font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-sm">check</span> <?= $g['nama'] ?>
                                </span>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <div class="p-6 bg-surface-container-lowest rounded-xl border border-outline-variant/5">
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-4">Informasi Tambahan</p>
                        <div class="space-y-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-on-surface-variant">Metode</span>
                                <span class="font-bold">Forward Chaining</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-on-surface-variant">ID Diagnosa</span>
                                <span class="font-bold">#<?= $id ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="riwayat.php" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary-dim transition-all shadow-lg text-center">
                    <span class="material-symbols-outlined">arrow_back</span>
                    Kembali ke Riwayat
                </a>
            </div>

        <?php else: ?>
            <div class="lg:col-span-12 bg-surface-container-low p-16 rounded-3xl text-center">
                <span class="material-symbols-outlined text-7xl text-on-surface-variant/20 mb-8">search_off</span>
                <h2 class="text-3xl font-bold text-on-surface mb-4 font-headline">Data Tidak Lengkap</h2>
                <p class="text-on-surface-variant max-w-lg mx-auto mb-10 text-lg">
                    Maaf, data penyakit terkait riwayat ini tidak dapat ditemukan dalam basis pengetahuan saat ini.
                </p>
                <a href="riwayat.php" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-on-primary rounded-xl font-bold hover:bg-primary-dim transition-all">
                    <span class="material-symbols-outlined">arrow_back</span> Kembali
                </a>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
