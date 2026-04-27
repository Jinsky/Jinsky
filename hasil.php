<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: konsultasi.php');
    exit;
}

$nama_merpati = $_POST['nama_merpati'] ?? 'Unnamed';
$selected_gejala = $_POST['gejala'] ?? [];

$diagnosis = get_diagnosa($pdo, $selected_gejala);

if ($diagnosis) {
    save_diagnosa($pdo, $nama_merpati, $diagnosis['id'], $selected_gejala, $diagnosis['confidence']);
}

$page_title = "Hasil Diagnosa";
include 'includes/header.php';
?>

<main class="pt-32 pb-20 px-8 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <div class="mb-16">
        <span class="bg-secondary-container text-on-secondary-container px-4 py-1.5 rounded-full text-sm font-bold tracking-wider uppercase mb-6 inline-block">
            Analisis Selesai
        </span>
        <h1 class="font-headline text-5xl md:text-6xl text-primary font-bold tracking-tight mb-6">Hasil Analisis Kesehatan</h1>
        <p class="text-on-surface-variant text-xl max-w-2xl leading-relaxed">
            Nama Pemilik: <span class="font-bold text-on-surface"><?= htmlspecialchars($nama_merpati) ?></span>. Berdasarkan pola gejala yang Anda berikan, sistem pakar kami telah mencapai kesimpulan berikut.
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
                        <p class="text-5xl font-headline font-black text-primary leading-none"><?= $diagnosis['confidence'] ?>%</p>
                        <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mt-2">Skor Keyakinan</p>
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

            <div class="bg-error-container/20 p-6 rounded-xl border border-error/10">
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-error">warning</span>
                    <div>
                        <h4 class="font-bold text-on-error-container">Catatan Penting</h4>
                        <p class="text-sm text-on-error-container opacity-80 mt-1 leading-relaxed">
                            Hasil ini didasarkan pada basis aturan sistem pakar. Untuk akurasi klinis yang pasti, segera bawa merpati Anda ke laboratorium atau dokter hewan spesialis avian jika gejala terus berlanjut.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Details -->
        <div class="lg:col-span-5 space-y-8 sticky top-28">
            <div class="bg-surface-container-low p-8 rounded-xl">
                <h3 class="font-headline text-xl text-primary mb-6">Ringkasan Gejala</h3>
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
                    <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest mb-4">Konteks Diagnostik</p>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">Metode</span>
                            <span class="font-bold">Forward Chaining</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-on-surface-variant">Waktu</span>
                            <span class="font-bold"><?= date('d M Y, H:i') ?> WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden relative aspect-video">
                <img class="w-full h-full object-cover" alt="Expert consultation" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAv6Cyh7PHS4jVbuTjoVDTl1fPAWlWfPB8YNPxJaX1n1LuK_GwIagh4H-G4vPpwzM45mcqijfFsk98WIDr4dSA1fYDKtSioH4mboqyxYNN-bKRzTSmtJ1lu5TgLFTPFysXmOpcAS8eGom5-M_WoMZk22kSGn44oZDAG0e2k71F2L9123DR6WxPZbynZ0iirtKnUD-6BGFAG1AHXyUE_JzAN3UXUQIkzL6lDyLItzS6R-vtHUgInPBxgDz8cnX_uRJVBwcQHVr-UI2nY"/>
                <div class="absolute inset-0 bg-primary/40 flex items-center justify-center p-8 text-center text-on-primary">
                    <div>
                        <p class="font-headline text-lg mb-4 italic">"Deteksi dini adalah landasan keselamatan kawanan."</p>
                        <a href="riwayat.php" class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-white/30 transition-all">Lihat Riwayat</a>
                    </div>
                </div>
            </div>

            <a href="konsultasi.php" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary-dim transition-all shadow-lg text-center">
                <span class="material-symbols-outlined">restart_alt</span>
                Diagnosa Ulang
            </a>
        </div>

        <?php else: ?>
        <!-- No Result -->
        <div class="lg:col-span-12 bg-surface-container-low p-16 rounded-3xl text-center">
            <span class="material-symbols-outlined text-7xl text-on-surface-variant/20 mb-8">search_off</span>
            <h2 class="text-3xl font-bold text-on-surface mb-4 font-headline">Diagnosis Tidak Ditemukan</h2>
            <p class="text-on-surface-variant max-w-lg mx-auto mb-10 text-lg">
                Maaf, pola gejala yang Anda berikan tidak cocok dengan data penyakit yang ada di basis pengetahuan kami. Hal ini bisa berarti kondisi yang sangat langka atau gejala yang saling bertentangan.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="konsultasi.php" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-on-primary rounded-xl font-bold hover:bg-primary-dim transition-all">
                    <span class="material-symbols-outlined">arrow_back</span> Coba Lagi
                </a>
                <a href="katalog.php" class="inline-flex items-center gap-2 px-8 py-4 border border-outline-variant text-primary rounded-xl font-bold hover:bg-surface-container transition-all">
                    <span class="material-symbols-outlined">menu_book</span> Lihat Katalog
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
