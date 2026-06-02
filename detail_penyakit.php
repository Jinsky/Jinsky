<?php
require_once 'includes/functions.php';
$page_title = "Detail Penyakit";
include 'includes/header.php';

$id = $_GET['id'] ?? '';
$penyakit = get_penyakit_by_id($pdo, $id);

if (!$penyakit) {
    header("Location: katalog.php");
    exit;
}
?>

<main class="pt-24 min-h-screen bg-surface-container-lowest">
    <div class="max-w-5xl mx-auto px-8 pb-20">
        <a href="katalog.php" class="inline-flex items-center gap-2 text-primary font-bold mb-10 hover:gap-4 transition-all">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Katalog
        </a>

        <div class="bg-white rounded-[3rem] shadow-xl shadow-primary/5 overflow-hidden border border-outline-variant/30">
            <!-- Header Section -->
            <div class="bg-primary p-12 text-on-primary">
                <div class="px-4 py-1.5 rounded-full bg-white/20 w-fit text-xs font-bold font-label uppercase tracking-widest mb-6">
                    KODE PENYAKIT: <?= $penyakit['id_penyakit'] ?>
                </div>
                <h1 class="text-5xl font-bold font-headline mb-4"><?= $penyakit['nama'] ?></h1>
            </div>

            <!-- Content Body -->
            <div class="p-12 space-y-12">
                <!-- Deskripsi -->
                <section>
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center text-secondary">
                            <span class="material-symbols-outlined">info</span>
                        </div>
                        <h2 class="text-2xl font-bold text-primary font-headline">Tentang Penyakit</h2>
                    </div>
                    <div class="prose prose-slate max-w-none text-on-surface-variant font-body leading-relaxed text-lg">
                        <?= nl2br($penyakit['deskripsi']) ?>
                    </div>
                </section>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                    <!-- Solusi -->
                    <section class="bg-surface-container-low p-8 rounded-[2rem]">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">medical_services</span>
                            </div>
                            <h2 class="text-xl font-bold text-primary font-headline">Solusi & Penanganan</h2>
                        </div>
                        <div class="text-on-surface-variant font-body leading-relaxed space-y-4">
                            <?= nl2br($penyakit['solusi']) ?>
                        </div>
                    </section>

                    <!-- Pencegahan -->
                    <section class="bg-surface-container-low p-8 rounded-[2rem]">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-tertiary-container flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined">shield_with_heart</span>
                            </div>
                            <h2 class="text-xl font-bold text-primary font-headline">Langkah Pencegahan</h2>
                        </div>
                        <div class="text-on-surface-variant font-body leading-relaxed space-y-4">
                            <?= nl2br($penyakit['pencegahan']) ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
