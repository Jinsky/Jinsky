<?php
require_once 'includes/functions.php';
include 'includes/header.php';

$gejala_list = get_all_gejala($pdo);

// Grouping symptoms for better UI
$categories = [
    'Gejala Fisik' => ['G01', 'G02', 'G06', 'G07', 'G08', 'G09', 'G15', 'G21', 'G22', 'G26', 'G30'],
    'Gejala Pencernaan & Ekskresi' => ['G03', 'G04', 'G05', 'G23', 'G24', 'G25', 'G27'],
    'Gejala Pernapasan' => ['G10', 'G11', 'G12', 'G13', 'G14'],
    'Gejala Saraf & Pergerakan' => ['G16', 'G17', 'G18', 'G19', 'G20', 'G28', 'G29']
];
?>

<main class="flex-grow pt-32 pb-24 px-6 md:px-12 max-w-screen-xl mx-auto w-full">
    <!-- Hero Header -->
    <header class="mb-16 relative">
        <div class="max-w-2xl">
            <span class="inline-flex items-center px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-xs font-bold uppercase tracking-widest mb-4">
                Diagnostic Tool
            </span>
            <h1 class="font-headline text-5xl md:text-6xl font-extrabold text-primary tracking-tighter leading-tight mb-6">
                Avian Symptom <span class="text-on-surface-variant/40 italic">Precision Analysis.</span>
            </h1>
            <p class="text-on-surface-variant text-lg leading-relaxed max-w-xl">
                Gunakan kerangka diagnostik tervalidasi pakar kami untuk mengidentifikasi potensi risiko kesehatan pada merpati Anda. Pilih semua gejala yang teramati untuk laporan presisi segera.
            </p>
        </div>
    </header>

    <!-- Diagnostic Form -->
    <form action="hasil.php" method="POST" class="space-y-12">
        <div class="bg-surface-container-low rounded-xl p-8 md:p-10 mb-8">
            <label class="block font-headline text-2xl font-extrabold text-on-surface tracking-tight mb-4">Nama Merpati / Identitas</label>
            <input type="text" name="nama_merpati" required placeholder="Contoh: Merpati Pos A" class="w-full bg-surface-container-lowest border-none rounded-lg p-4 focus:ring-2 focus:ring-primary/20 text-on-surface">
        </div>

        <?php foreach ($categories as $cat_name => $cat_ids): ?>
        <section class="bg-surface-container-low rounded-xl p-8 md:p-10">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-lg bg-surface-container-lowest flex items-center justify-center shadow-sm">
                    <span class="material-symbols-outlined text-primary">medical_services</span>
                </div>
                <div>
                    <h2 class="font-headline text-2xl font-extrabold text-on-surface tracking-tight"><?= $cat_name ?></h2>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php
                foreach ($gejala_list as $g) {
                    if (in_all_categories($g['id'], $categories) && !in_array($g['id'], $cat_ids)) continue;
                    if (in_array($g['id'], $cat_ids)):
                ?>
                <label class="group flex items-center p-4 bg-surface-container-lowest rounded-lg cursor-pointer border border-transparent hover:border-primary/20 transition-all">
                    <input name="gejala[]" value="<?= $g['id'] ?>" class="custom-checkbox w-6 h-6 rounded border-surface-container-highest text-primary focus:ring-primary transition-all" type="checkbox"/>
                    <span class="ml-4 text-on-surface font-semibold"><?= $g['nama'] ?></span>
                </label>
                <?php
                    endif;
                }
                ?>
            </div>
        </section>
        <?php endforeach; ?>

        <!-- Gejala Lainnya (not in categories) -->
        <?php
        $uncategorized = [];
        $all_cat_ids = [];
        foreach($categories as $c) $all_cat_ids = array_merge($all_cat_ids, $c);
        foreach($gejala_list as $g) if(!in_array($g['id'], $all_cat_ids)) $uncategorized[] = $g;

        if (!empty($uncategorized)):
        ?>
        <section class="bg-surface-container-low rounded-xl p-8 md:p-10">
            <h2 class="font-headline text-2xl font-extrabold text-on-surface tracking-tight mb-8">Gejala Lainnya</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php foreach ($uncategorized as $g): ?>
                <label class="group flex items-center p-4 bg-surface-container-lowest rounded-lg cursor-pointer border border-transparent hover:border-primary/20 transition-all">
                    <input name="gejala[]" value="<?= $g['id'] ?>" class="custom-checkbox w-6 h-6 rounded border-surface-container-highest text-primary focus:ring-primary transition-all" type="checkbox"/>
                    <span class="ml-4 text-on-surface font-semibold"><?= $g['nama'] ?></span>
                </label>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- Action Area -->
        <div class="mt-20 flex flex-col md:flex-row items-center justify-between p-10 bg-primary rounded-xl overflow-hidden relative">
            <div class="relative z-10 text-center md:text-left mb-8 md:mb-0">
                <h3 class="font-headline text-3xl font-extrabold text-on-primary mb-2">Ready for Diagnosis?</h3>
                <p class="text-on-primary/80 max-w-sm">Algoritma klinis kami akan menganalisis pilihan Anda terhadap basis pengetahuan penyakit avian.</p>
            </div>
            <button type="submit" class="relative z-10 bg-on-primary text-primary hover:bg-primary-container px-12 py-5 rounded-full font-headline font-black text-xl tracking-tight transition-all active:scale-95 shadow-xl">
                Analisis Sekarang
            </button>
            <div class="absolute right-0 top-0 w-64 h-64 bg-primary-dim rounded-full blur-3xl opacity-50 -mr-32 -mt-32"></div>
        </div>
    </form>
</main>

<?php
function in_all_categories($id, $categories) {
    foreach($categories as $c) if(in_array($id, $c)) return true;
    return false;
}
include 'includes/footer.php';
?>
