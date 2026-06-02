<?php
require_once 'includes/functions.php';
$page_title = "Riwayat Diagnosa";
include 'includes/header.php';

$search = $_GET['search'] ?? '';
$id_penyakit_filter = $_GET['id_penyakit'] ?? '';

$riwayat_list = get_riwayat($pdo, $search, $id_penyakit_filter);
$penyakit_all = get_all_penyakit($pdo);
?>

<main class="pt-24 min-h-screen bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto px-8 pb-20">
        <!-- Dashboard Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-12">
            <div>
                <h1 class="text-5xl font-bold text-primary font-headline mb-4">Arsip Diagnosa</h1>
                <p class="text-xl text-on-surface-variant font-body">Rekaman riwayat pemeriksaan kesehatan merpati Anda.</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="text-right">
                    <p class="text-xs font-bold text-secondary uppercase tracking-[0.2em] font-label">Total Pemeriksaan</p>
                    <p class="text-4xl font-bold text-primary"><?= count($riwayat_list) ?></p>
                </div>
                <div class="w-16 h-16 rounded-2xl bg-secondary-container flex items-center justify-center text-secondary">
                    <span class="material-symbols-outlined text-4xl">history</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-primary/5 p-8 mb-12 border border-outline-variant/30">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-6 items-end">
                <div class="md:col-span-5">
                    <label class="block text-sm font-bold text-on-surface-variant font-label uppercase tracking-widest mb-3 ml-4">Cari Pemilik</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Nama pemilik..." class="w-full pl-16 pr-8 py-4 bg-surface-container rounded-2xl border-none outline-none focus:ring-2 focus:ring-primary/20 font-body">
                    </div>
                </div>

                <div class="md:col-span-5">
                    <label class="block text-sm font-bold text-on-surface-variant font-label uppercase tracking-widest mb-3 ml-4">Filter Penyakit</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-on-surface-variant">category</span>
                        <select name="id_penyakit" class="w-full pl-16 pr-8 py-4 bg-surface-container rounded-2xl border-none outline-none focus:ring-2 focus:ring-primary/20 font-body appearance-none">
                            <option value="">Semua Penyakit</option>
                            <?php foreach($penyakit_all as $p): ?>
                                <option value="<?= $p['id_penyakit'] ?>" <?= $id_penyakit_filter == $p['id_penyakit'] ? 'selected' : '' ?>><?= $p['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="w-full bg-primary text-white py-4 rounded-2xl font-bold hover:shadow-lg hover:shadow-primary/20 transition-all">Filter</button>
                </div>
            </form>
        </div>

        <!-- History Table -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-primary/5 border border-outline-variant/30 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant/30">
                            <th class="p-8 font-bold text-primary font-headline">Waktu Diagnosa</th>
                            <th class="p-8 font-bold text-primary font-headline">Nama Pemilik</th>
                            <th class="p-8 font-bold text-primary font-headline">Hasil Analisis</th>
                            <th class="p-8 font-bold text-primary font-headline">Kecocokan</th>
                            <th class="p-8 text-right"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/20">
                        <?php if (empty($riwayat_list)): ?>
                            <tr>
                                <td colspan="5" class="p-20 text-center">
                                    <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">folder_open</span>
                                    <p class="text-xl text-on-surface-variant font-body">Belum ada riwayat diagnosa yang tercatat.</p>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($riwayat_list as $r): ?>
                            <tr class="group hover:bg-surface-container-lowest transition-colors">
                                <td class="p-8">
                                    <p class="font-bold text-primary font-body"><?= date('d M Y', strtotime($r['tanggal'])) ?></p>
                                    <p class="text-xs text-on-surface-variant font-label"><?= date('H:i', strtotime($r['tanggal'])) ?> WIB</p>
                                </td>
                                <td class="p-8">
                                    <span class="font-bold text-on-surface-variant font-body"><?= $r['nama_merpati'] ?></span>
                                </td>
                                <td class="p-8">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center text-primary">
                                            <span class="material-symbols-outlined text-sm">clinical_notes</span>
                                        </div>
                                        <span class="font-bold text-primary font-headline"><?= $r['nama_penyakit'] ?></span>
                                    </div>
                                </td>
                                <td class="p-8">
                                    <div class="flex flex-col gap-1 w-32">
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-[10px] font-bold text-secondary font-label uppercase tracking-wider">Kecocokan</span>
                                            <span class="text-xs font-bold text-primary"><?= $r['confidence'] ?>%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
                                            <div class="h-full bg-secondary" style="width: <?= $r['confidence'] ?>%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-8 text-right">
                                    <a href="detail_riwayat.php?id=<?= $r['id_diagnosa'] ?>" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-surface-container hover:bg-primary hover:text-white transition-all font-bold text-sm">
                                        Detail
                                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
