<?php
require_once 'includes/functions.php';
$page_title = "Katalog Penyakit & Gejala";
include 'includes/header.php';

$active_tab = $_GET['tab'] ?? 'penyakit';
$search = $_GET['search'] ?? '';

$items = [];
if ($active_tab === 'penyakit') {
    $items = get_all_penyakit($pdo);
} else {
    $items = get_all_gejala($pdo);
}

if (!empty($search)) {
    $items = array_filter($items, function($item) use ($search) {
        return strpos(strtolower($item['nama']), strtolower($search)) !== false;
    });
}
?>

<main class="pt-24 min-h-screen bg-surface-container-lowest">
    <div class="max-w-7xl mx-auto px-8 pb-20">
        <!-- Search & Filter Header -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-primary/5 p-8 mb-12 border border-outline-variant/30">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div>
                    <h1 class="text-4xl font-bold text-primary font-headline mb-2">Ensiklopedia Kesehatan</h1>
                    <p class="text-on-surface-variant font-body">Pelajari berbagai jenis penyakit dan gejala pada merpati secara mendalam.</p>
                </div>

                <div class="flex items-center p-1 bg-surface-container rounded-full w-fit">
                    <a href="?tab=penyakit" class="px-6 py-2 rounded-full font-bold transition-all <?= $active_tab === 'penyakit' ? 'bg-primary text-white shadow-lg' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">Info Penyakit</a>
                    <a href="?tab=gejala" class="px-6 py-2 rounded-full font-bold transition-all <?= $active_tab === 'gejala' ? 'bg-primary text-white shadow-lg' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">Info Gejala</a>
                </div>
            </div>

            <div class="mt-8 relative">
                <form method="GET" class="relative group">
                    <input type="hidden" name="tab" value="<?= $active_tab ?>">
                    <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" placeholder="Cari <?= $active_tab ?>..." class="w-full pl-16 pr-8 py-4 bg-surface-container border-none rounded-full outline-none focus:ring-2 focus:ring-primary/20 transition-all font-body">
                </form>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if (empty($items)): ?>
                <div class="col-span-full py-20 text-center">
                    <span class="material-symbols-outlined text-6xl text-outline-variant mb-4">search_off</span>
                    <p class="text-xl text-on-surface-variant font-body">Tidak ditemukan hasil untuk "<?= htmlspecialchars($search) ?>"</p>
                </div>
            <?php endif; ?>

            <?php foreach ($items as $item): ?>
                <?php if ($active_tab === 'penyakit'): ?>
                    <div class="group bg-white rounded-3xl p-6 border border-outline-variant/30 hover:border-primary/30 hover:shadow-2xl hover:shadow-primary/5 transition-all flex flex-col items-stretch">
                        <div class="flex items-center justify-between mb-6">
                            <div class="px-4 py-1.5 rounded-full bg-primary-container text-primary text-xs font-bold font-label uppercase tracking-widest">
                                <?= $item['id_penyakit'] ?>
                            </div>
                            <span class="material-symbols-outlined text-outline-variant group-hover:text-primary transition-colors">clinical_notes</span>
                        </div>
                        <h3 class="text-xl font-bold text-primary font-headline mb-4 line-clamp-2 h-16"><?= $item['nama'] ?></h3>
                        <div class="relative mb-6">
                            <p class="text-on-surface-variant font-body line-clamp-3 text-sm leading-relaxed">
                                <?= strip_tags(str_replace(['\n', '\r'], ' ', $item['deskripsi'])) ?>
                            </p>
                        </div>
                        <div class="mt-auto pt-6 border-t border-outline-variant/30">
                            <a href="detail_penyakit.php?id=<?= $item['id_penyakit'] ?>" class="flex items-center justify-between group/btn">
                                <span class="font-bold text-primary font-label">Baca Selengkapnya</span>
                                <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center group-hover/btn:bg-primary group-hover/btn:text-white transition-all">
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </div>
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="group bg-white rounded-2xl p-6 border border-outline-variant/30 hover:border-secondary/30 transition-all flex items-center gap-6 h-24 hover:shadow-md hover:-translate-y-1">
                        <div class="w-12 h-12 rounded-xl bg-primary-container flex items-center justify-center shrink-0">
                            <span class="text-primary font-bold font-mono text-sm uppercase"><?= $item['id_gejala'] ?></span>
                        </div>
                        <h3 class="font-bold text-primary font-headline leading-tight"><?= $item['nama'] ?></h3>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
