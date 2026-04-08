<?php
require_once 'includes/functions.php';
include 'includes/header.php';

$riwayat = get_riwayat($pdo);
?>

<main class="mt-24 px-8 pb-16 max-w-7xl mx-auto w-full">
    <!-- Header Section -->
    <header class="mb-12">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="max-w-2xl">
                <h1 class="text-4xl font-extrabold tracking-tighter text-on-surface mb-2">Riwayat Diagnosa</h1>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Arsip komprehensif penilaian kesehatan avian. Pantau perkembangan kasus masa lalu dan kelola database kesehatan koloni Anda dengan presisi klinis.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="konsultasi.php" class="bg-primary text-on-primary px-6 py-2.5 rounded-xl font-semibold flex items-center gap-2 hover:bg-primary-dim transition-colors">
                    <span class="material-symbols-outlined text-lg">add_chart</span>
                    Diagnosa Baru
                </a>
            </div>
        </div>
    </header>

    <!-- History Content -->
    <div class="bg-surface-container-low rounded-xl overflow-hidden border border-outline-variant/10 shadow-sm">
        <div class="hidden md:grid grid-cols-12 gap-4 px-8 py-4 bg-surface-container-high/50 text-xs font-bold uppercase tracking-widest text-on-surface-variant">
            <div class="col-span-2">Tanggal</div>
            <div class="col-span-3">Identitas Merpati</div>
            <div class="col-span-3">Diagnosa Penyakit</div>
            <div class="col-span-2 text-center">Confidence</div>
            <div class="col-span-2 text-right">Aksi</div>
        </div>

        <div class="divide-y divide-outline-variant/10">
            <?php if (empty($riwayat)): ?>
            <div class="p-12 text-center text-on-surface-variant">
                <span class="material-symbols-outlined text-4xl mb-4 block">folder_open</span>
                Belum ada data riwayat diagnosa.
            </div>
            <?php else: ?>
                <?php foreach ($riwayat as $r): ?>
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 px-8 py-6 items-center hover:bg-surface-container-highest/30 transition-colors">
                    <div class="col-span-2 flex flex-col">
                        <span class="text-on-surface font-semibold"><?= date('d M Y', strtotime($r['tanggal'])) ?></span>
                        <span class="text-xs text-on-surface-variant"><?= date('H:i', strtotime($r['tanggal'])) ?> WIB</span>
                    </div>
                    <div class="col-span-3 flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-primary font-bold">
                            <?= strtoupper(substr($r['nama_merpati'], 0, 1)) ?>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-bold text-on-surface"><?= htmlspecialchars($r['nama_merpati']) ?></span>
                            <span class="text-xs text-on-surface-variant">ID: #<?= str_pad($r['id'], 4, '0', STR_PAD_LEFT) ?></span>
                        </div>
                    </div>
                    <div class="col-span-3">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined <?= $r['id_penyakit'] ? 'text-error' : 'text-on-surface-variant' ?> text-lg">medical_services</span>
                            <span class="font-medium text-on-surface"><?= $r['nama_penyakit'] ?? 'Tidak Terdeteksi' ?></span>
                        </div>
                    </div>
                    <div class="col-span-2 text-center">
                        <span class="text-primary font-bold text-lg"><?= $r['confidence'] ?>%</span>
                    </div>
                    <div class="col-span-2 flex justify-end">
                        <button onclick="alert('Gejala Terpilih: <?= $r['gejala_terpilih'] ?>')" class="p-2 hover:bg-surface-container-highest rounded-lg transition-colors text-secondary">
                            <span class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
