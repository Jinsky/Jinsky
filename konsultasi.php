<?php
require_once 'includes/functions.php';
$page_title = "Konsultasi";
include 'includes/header.php';

$gejala_list = get_all_gejala($pdo);

// Grouping for the 2-step UI
$step1_ids = ['G01', 'G03', 'G04', 'G05', 'G06', 'G07', 'G08', 'G09', 'G10', 'G11', 'G12', 'G13', 'G14', 'G15', 'G21', 'G22', 'G25', 'G28', 'G30'];
$step2_ids = ['G02', 'G16', 'G17', 'G18', 'G19', 'G20', 'G23', 'G24', 'G26', 'G27', 'G29'];

$step1_gejala = array_filter($gejala_list, function($g) use ($step1_ids) { return in_array($g['id'], $step1_ids); });
$step2_gejala = array_filter($gejala_list, function($g) use ($step2_ids) { return in_array($g['id'], $step2_ids); });
?>

<main class="pt-32 pb-20 px-8 max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="mb-16">
        <h1 class="font-headline text-5xl md:text-6xl text-primary font-bold tracking-tight mb-6">Analisis Kesehatan Avian</h1>
        <p class="text-on-surface-variant text-xl max-w-2xl leading-relaxed">
            Platform diagnostik mandiri berbasis riset untuk mendeteksi dini masalah kesehatan pada merpati Anda. Pilih gejala yang diamati untuk memulai kalkulasi.
        </p>
    </div>

    <form action="hasil.php" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
        <!-- Symptom Selection Area -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-surface-container-low p-8 rounded-xl">
                <label class="block font-headline text-2xl font-bold text-primary mb-6">Identitas Merpati</label>
                <input type="text" name="nama_merpati" required placeholder="Masukkan nama atau ID merpati..." class="w-full bg-surface-container-lowest border-none rounded-xl p-4 focus:ring-2 focus:ring-primary/20 text-on-surface">
            </div>

            <div class="bg-surface-container-low p-8 rounded-xl">
                <div class="flex items-center gap-3 mb-8">
                    <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-sm font-bold">Langkah 1</span>
                    <h2 class="font-headline text-2xl text-primary">Identifikasi Gejala Fisik</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($step1_gejala as $g): ?>
                    <label class="relative flex items-start p-4 bg-surface-container-lowest rounded-xl cursor-pointer hover:bg-primary-fixed transition-colors group border-2 border-transparent has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/30">
                        <input name="gejala[]" value="<?= $g['id'] ?>" class="mt-1 w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/>
                        <div class="ml-4">
                            <span class="block font-bold text-on-surface"><?= $g['id'] ?> - <?= $g['nama'] ?></span>
                            <span class="text-sm text-on-surface-variant">Teramati pada kondisi fisik luar.</span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bg-surface-container-low p-8 rounded-xl">
                <div class="flex items-center gap-3 mb-8">
                    <span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-sm font-bold">Langkah 2</span>
                    <h2 class="font-headline text-2xl text-primary">Observasi Perilaku & Kondisi Lain</h2>
                </div>
                <div class="space-y-4">
                    <?php foreach ($step2_gejala as $g): ?>
                    <label class="relative flex items-center p-4 bg-surface-container-lowest rounded-xl cursor-pointer hover:bg-primary-fixed transition-colors border-2 border-transparent has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/30">
                        <input name="gejala[]" value="<?= $g['id'] ?>" class="w-5 h-5 rounded border-outline-variant text-primary focus:ring-primary" type="checkbox"/>
                        <div class="ml-4">
                            <span class="block font-bold text-on-surface"><?= $g['id'] ?> - <?= $g['nama'] ?></span>
                            <span class="text-sm text-on-surface-variant">Perubahan pada perilaku atau gejala sistemik.</span>
                        </div>
                    </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-gradient-to-r from-primary to-primary-container text-on-primary px-10 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-primary/20 transition-all flex items-center gap-3">
                    <span class="material-symbols-outlined">analytics</span>
                    Diagnosa Sekarang
                </button>
            </div>
        </div>

        <!-- Insights Area (Sidebar) -->
        <div class="lg:col-span-5 sticky top-28 space-y-8">
            <div class="bg-surface-container border-l-4 border-secondary p-8 rounded-r-xl">
                <h3 class="font-headline text-xl text-primary mb-6">Informasi Diagnosa</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed mb-6">
                    Sistem kami menggunakan metode <span class="font-bold">Forward Chaining</span>. Setiap gejala yang Anda pilih akan dicocokkan dengan basis aturan pakar untuk menghasilkan kemungkinan diagnosis yang paling akurat.
                </p>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-sm mt-0.5">check_circle</span>
                        <p class="text-xs text-on-surface font-medium">Data diverifikasi oleh spesialis avian.</p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-sm mt-0.5">check_circle</span>
                        <p class="text-xs text-on-surface font-medium">Analisis real-time berdasarkan gejala.</p>
                    </div>
                </div>
            </div>

            <div class="bg-error-container/20 p-6 rounded-xl border border-error/10">
                <div class="flex gap-4">
                    <span class="material-symbols-outlined text-error">warning</span>
                    <div>
                        <h4 class="font-bold text-on-error-container">Catatan Penting</h4>
                        <p class="text-sm text-on-error-container opacity-80 mt-1 leading-relaxed">
                            Hasil kalkulasi ini bersifat indikatif berdasarkan rulebase penelitian. Harap konsultasikan dengan dokter hewan spesialis unggas untuk diagnosis medis yang akurat.
                        </p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl overflow-hidden relative aspect-video">
                <img class="w-full h-full object-cover" alt="Veterinarian examining a pigeon" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAv6Cyh7PHS4jVbuTjoVDTl1fPAWlWfPB8YNPxJaX1n1LuK_GwIagh4H-G4vPpwzM45mcqijfFsk98WIDr4dSA1fYDKtSioH4mboqyxYNN-bKRzTSmtJ1lu5TgLFTPFysXmOpcAS8eGom5-M_WoMZk22kSGn44oZDAG0e2k71F2L9123DR6WxPZbynZ0iirtKnUD-6BGFAG1AHXyUE_JzAN3UXUQIkzL6lDyLItzS6R-vtHUgInPBxgDz8cnX_uRJVBwcQHVr-UI2nY"/>
                <div class="absolute inset-0 bg-primary/40 flex items-center justify-center p-8 text-center">
                    <div class="text-on-primary">
                        <p class="font-headline text-lg mb-4 italic">"Kesehatan merpati Anda adalah prioritas riset kami."</p>
                        <a href="tentang.php" class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-white/30 transition-all">Hubungi Ahli</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</main>

<?php include 'includes/footer.php'; ?>
