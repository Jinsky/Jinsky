<?php
require_once 'includes/functions.php';

$id = $_GET['id'] ?? '';
$penyakit = get_penyakit_by_id($pdo, $id);

if (!$penyakit) {
    header('Location: katalog.php');
    exit;
}

$page_title = "Detail Penyakit: " . $penyakit['nama'];
include 'includes/header.php';
?>

<main class="pt-32 pb-20 px-8 max-w-5xl mx-auto">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-sm text-on-surface-variant mb-8">
        <a href="index.php" class="hover:text-primary transition-colors">Beranda</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <a href="katalog.php" class="hover:text-primary transition-colors">Katalog Penyakit</a>
        <span class="material-symbols-outlined text-xs">chevron_right</span>
        <span class="font-bold text-primary"><?= $penyakit['nama'] ?></span>
    </nav>

    <!-- Content Card -->
    <div class="bg-surface-container-lowest rounded-3xl overflow-hidden shadow-sm border border-outline-variant/10">
        <!-- Header -->
        <div class="bg-primary p-12 text-on-primary">
            <div class="flex items-center gap-3 mb-6">
                <span class="px-3 py-1 bg-white/20 backdrop-blur-md rounded-full text-xs font-bold tracking-widest uppercase">Detail Kondisi</span>
                <span class="material-symbols-outlined">microbiology</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-headline font-bold mb-4"><?= $penyakit['nama'] ?></h1>
            <p class="text-on-primary/80 text-lg max-w-2xl">
                Informasi mendalam mengenai penyebab, gejala klinis, dan langkah medis yang diperlukan.
            </p>
        </div>

        <!-- Body -->
        <div class="p-12 space-y-12">
            <!-- Deskripsi -->
            <section>
                <h2 class="text-2xl font-headline font-bold text-primary mb-6 flex items-center gap-3">
                    <span class="w-2 h-8 bg-secondary rounded-full"></span>
                    Deskripsi Klinis
                </h2>
                <div class="text-on-surface-variant leading-relaxed text-lg">
                    <?= nl2br($penyakit['deskripsi']) ?>
                </div>
            </section>

            <!-- Grid: Solusi & Pencegahan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-8 border-t border-outline-variant/10">
                <section class="bg-surface-container-low p-8 rounded-2xl">
                    <h3 class="text-xl font-headline font-bold text-secondary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined">medical_services</span>
                        Langkah Penanganan
                    </h3>
                    <div class="text-on-surface-variant leading-relaxed space-y-4">
                        <?= nl2br($penyakit['solusi']) ?>
                    </div>
                </section>

                <section class="bg-surface-container-low p-8 rounded-2xl">
                    <h3 class="text-xl font-headline font-bold text-tertiary mb-6 flex items-center gap-3">
                        <span class="material-symbols-outlined">shield</span>
                        Strategi Pencegahan
                    </h3>
                    <div class="text-on-surface-variant leading-relaxed space-y-4">
                        <?= nl2br($penyakit['pencegahan']) ?>
                    </div>
                </section>
            </div>
        </div>

        <!-- Footer Action -->
        <div class="p-12 bg-surface-container flex flex-col md:flex-row items-center justify-between gap-8 border-t border-outline-variant/10">
            <div>
                <h4 class="font-bold text-primary mb-1">Punya Gejala Serupa?</h4>
                <p class="text-sm text-on-surface-variant">Lakukan diagnosa mandiri sekarang untuk kepastian lebih lanjut.</p>
            </div>
            <a href="konsultasi.php" class="px-10 py-4 bg-primary text-on-primary rounded-xl font-bold hover:bg-primary-dim transition-all shadow-lg flex items-center gap-2">
                <span class="material-symbols-outlined">analytics</span>
                Mulai Konsultasi
            </a>
        </div>
    </div>

    <!-- Back Button -->
    <div class="mt-12 flex justify-center">
        <a href="katalog.php" class="text-primary font-bold flex items-center gap-2 hover:gap-4 transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Katalog
        </a>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
