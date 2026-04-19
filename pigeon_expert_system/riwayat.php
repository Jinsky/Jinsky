<?php
require_once 'includes/functions.php';
$hide_top_nav = true;
$page_title = "Riwayat Diagnosa";
include 'includes/header.php';

$riwayat = get_riwayat($pdo);
$total_diagnosa = count($riwayat);
?>

<div class="bg-surface text-on-surface min-h-screen flex w-full">
    <!-- Sidebar -->
    <aside class="hidden md:flex flex-col h-screen w-64 bg-[#eaeef2] dark:bg-[#171c1f] sticky top-0 py-8">
        <div class="px-8 mb-10 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined">clinical_notes</span>
            </div>
            <div>
                <p class="font-headline font-bold text-primary tracking-tight leading-none">Clinical Vitality</p>
                <p class="text-[10px] text-primary/60 uppercase tracking-widest font-bold mt-1">Avian Atelier</p>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center text-[#171c1f]/60 dark:text-[#ffffff]/60 px-8 py-3 hover:bg-[#f6fafe]/50 dark:hover:bg-[#ffffff]/10 transition-all font-manrope text-sm font-medium" href="index.php">
                <span class="material-symbols-outlined mr-3">grid_view</span> Overview
            </a>
            <a class="flex items-center text-[#171c1f]/60 dark:text-[#ffffff]/60 px-8 py-3 hover:bg-[#f6fafe]/50 dark:hover:bg-[#ffffff]/10 transition-all font-manrope text-sm font-medium" href="katalog.php">
                <span class="material-symbols-outlined mr-3">flutter_dash</span> Avian Profiles
            </a>
            <a class="flex items-center text-[#171c1f]/60 dark:text-[#ffffff]/60 px-8 py-3 hover:bg-[#f6fafe]/50 dark:hover:bg-[#ffffff]/10 transition-all font-manrope text-sm font-medium" href="konsultasi.php">
                <span class="material-symbols-outlined mr-3">biotech</span> Lab Results
            </a>
            <a class="flex items-center bg-[#ffffff] dark:bg-[#2a6069] text-[#005C97] dark:text-white rounded-l-full ml-4 pl-4 py-3 shadow-sm font-manrope text-sm font-medium translate-x-1 duration-200" href="riwayat.php">
                <span class="material-symbols-outlined mr-3">history</span> Riwayat
            </a>
            <a class="flex items-center text-[#171c1f]/60 dark:text-[#ffffff]/60 px-8 py-3 hover:bg-[#f6fafe]/50 dark:hover:bg-[#ffffff]/10 transition-all font-manrope text-sm font-medium" href="tentang.php">
                <span class="material-symbols-outlined mr-3">settings</span> Settings
            </a>
        </nav>
        <div class="px-8 mt-auto pt-6 border-t border-outline-variant/10">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl overflow-hidden bg-surface-container">
                    <img alt="Dr. Pigeon" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDGqtDDBuS7lzEngXy9IeeaaKGr7hfKdjj4UBf2cIffBXY76U_pLzxCHMTHG7MbeypMyXoKgpzam_F5cEh4MWB5YLchwTTZlIy3Oj8UxMdeoZD2EMeEhEI13I6-43kGCFnWs6MPfhDxACmHzzIGyKFsP5WgiYrasHtxenqDBhuTIa5MtBQRjbvRBlAuHaciEhfkAUp9rPzAzIc8K1b3sEJpUOqGOH5qDyz_A-8bayhY3oZoFhZwl_2TgjrTjCHyLL1R6tyqfiVWqKl0"/>
                </div>
                <div class="overflow-hidden">
                    <p class="text-sm font-bold truncate">Dr. Pigeon</p>
                    <p class="text-xs text-on-surface-variant">Avian Specialist</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden relative">
        <header class="fixed top-0 right-0 left-0 md:left-64 z-50 px-8 py-4 bg-[#f6fafe]/80 dark:bg-[#171c1f]/80 backdrop-blur-xl flex justify-between items-center shadow-sm shadow-[#171c1f]/5">
            <h1 class="font-headline text-2xl font-bold tracking-tight text-primary">Riwayat Diagnosa</h1>
            <div class="flex items-center gap-6">
                <div class="relative hidden lg:block">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline scale-75">search</span>
                    <input class="bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm w-64 focus:ring-2 focus:ring-primary/20" placeholder="Cari diagnosa atau pasien..." type="text"/>
                </div>
                <div class="flex items-center gap-4 text-primary">
                    <button class="scale-95 active:opacity-80 transition-all material-symbols-outlined">notifications</button>
                    <button class="scale-95 active:opacity-80 transition-all material-symbols-outlined">account_circle</button>
                </div>
            </div>
        </header>

        <div class="pt-24 px-8 pb-12">
            <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div class="max-w-2xl">
                    <p class="text-on-surface-variant font-medium mb-2 uppercase tracking-widest text-[10px]">Arsip Laboratorium</p>
                    <h2 class="text-4xl font-headline text-primary mb-4 leading-tight">Pantau perkembangan kesehatan populasi avian Anda.</h2>
                    <p class="text-on-surface-variant text-sm leading-relaxed">Berikut adalah catatan komprehensif dari penilaian kesehatan yang dilakukan. Gunakan filter untuk meninjau kasus spesifik atau unduh laporan untuk keperluan medis lebih lanjut.</p>
                </div>
                <div class="flex gap-2">
                    <button class="px-6 py-2.5 rounded-xl bg-secondary-container text-on-secondary-container text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-lg">filter_list</span> Filter Riwayat
                    </button>
                    <a href="konsultasi.php" class="px-6 py-2.5 rounded-xl bg-primary text-on-primary text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-lg">add</span> Diagnosa Baru
                    </a>
                </div>
            </div>

            <div class="space-y-4">
                <?php if (empty($riwayat)): ?>
                <div class="bg-surface-container-lowest rounded-xl p-12 text-center text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl mb-4 block">folder_open</span>
                    Belum ada data riwayat diagnosa.
                </div>
                <?php else: ?>
                    <?php foreach ($riwayat as $r): ?>
                    <div class="bg-surface-container-lowest rounded-xl p-6 flex flex-col lg:flex-row lg:items-center gap-6 transition-all hover:bg-surface-container-low/50 relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 <?= $r['id_penyakit'] ? 'bg-tertiary' : 'bg-secondary' ?>"></div>
                        <div class="lg:w-48">
                            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-tighter mb-1">Tanggal Assessment</p>
                            <p class="text-on-surface font-bold"><?= date('d M Y', strtotime($r['tanggal'])) ?></p>
                            <p class="text-xs text-on-surface-variant"><?= date('H:i', strtotime($r['tanggal'])) ?> WIB</p>
                        </div>
                        <div class="flex-1">
                            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-tighter mb-2">Identitas Merpati</p>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-primary font-bold text-xs">
                                    <?= strtoupper(substr($r['nama_merpati'], 0, 1)) ?>
                                </div>
                                <span class="font-bold text-on-surface"><?= htmlspecialchars($r['nama_merpati']) ?></span>
                            </div>
                        </div>
                        <div class="lg:w-64">
                            <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-tighter mb-1">Hasil Diagnosa</p>
                            <div class="flex items-center gap-3">
                                <span class="text-lg font-headline font-bold text-primary"><?= $r['nama_penyakit'] ?? 'Tidak Terdeteksi' ?></span>
                                <span class="bg-<?= $r['id_penyakit'] ? 'error' : 'secondary' ?>-container text-on-<?= $r['id_penyakit'] ? 'error' : 'secondary' ?>-container text-[10px] font-bold px-2 py-0.5 rounded-full"><?= $r['confidence'] ?>% Match</span>
                            </div>
                        </div>
                        <div class="flex justify-end lg:w-40">
                            <button onclick="alert('Gejala: <?= $r['gejala_terpilih'] ?>')" class="text-primary text-sm font-bold flex items-center gap-1 hover:gap-2 transition-all group">
                                Lihat Detail <span class="material-symbols-outlined text-lg">chevron_right</span>
                            </button>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-primary p-8 rounded-2xl text-on-primary flex flex-col justify-between h-48 relative overflow-hidden shadow-xl">
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl opacity-10">biotech</span>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Total Diagnosa</p>
                    <p class="text-5xl font-headline font-bold"><?= $total_diagnosa ?></p>
                    <p class="text-sm opacity-70">+12% dari bulan lalu</p>
                </div>
                <div class="bg-tertiary-container p-8 rounded-2xl text-on-tertiary-container flex flex-col justify-between h-48 relative overflow-hidden shadow-xl">
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl opacity-10">warning</span>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Kasus Kritikal</p>
                    <p class="text-5xl font-headline font-bold text-on-tertiary">08</p>
                    <p class="text-sm opacity-70">Memerlukan atensi segera</p>
                </div>
                <div class="bg-secondary p-8 rounded-2xl text-on-secondary flex flex-col justify-between h-48 relative overflow-hidden shadow-xl">
                    <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl opacity-10">health_and_safety</span>
                    <p class="text-xs font-bold uppercase tracking-widest opacity-80">Rasio Kesembuhan</p>
                    <p class="text-5xl font-headline font-bold">89%</p>
                    <p class="text-sm opacity-70">Program preventif efektif</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Mobile Nav -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 h-16 bg-[#f6fafe]/90 backdrop-blur-xl flex justify-around items-center border-t border-outline-variant/10 z-[100]">
        <a href="index.php" class="flex flex-col items-center gap-1 text-on-surface-variant">
            <span class="material-symbols-outlined">grid_view</span>
        </a>
        <a href="katalog.php" class="flex flex-col items-center gap-1 text-on-surface-variant">
            <span class="material-symbols-outlined">flutter_dash</span>
        </a>
        <a href="riwayat.php" class="flex flex-col items-center gap-1 text-primary">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">history</span>
        </a>
        <a href="tentang.php" class="flex flex-col items-center gap-1 text-on-surface-variant">
            <span class="material-symbols-outlined">settings</span>
        </a>
    </div>
</div>

<?php
// No footer needed as it has its own layout, but we need to close tags
?>
</body>
</html>
