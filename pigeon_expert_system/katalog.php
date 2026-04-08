<?php
require_once 'includes/functions.php';
include 'includes/header.php';

$penyakit_list = get_all_penyakit($pdo);
?>

<main class="pt-28 pb-20 px-8 max-w-screen-2xl mx-auto">
    <!-- Hero & Search Section -->
    <section class="mb-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-end">
            <div class="space-y-6">
                <span class="inline-block px-4 py-1 rounded-full bg-primary-container text-on-primary-container text-xs font-bold tracking-widest uppercase">Clinical Database</span>
                <h1 class="text-5xl md:text-6xl font-headline font-black text-primary tracking-tight leading-[1.1]">
                    Avian Pathogen <br/><span class="text-on-surface-variant font-light italic">Catalog</span>
                </h1>
                <p class="text-lg text-on-surface-variant max-w-xl leading-relaxed">
                    Akses data klinis presisi tentang penyakit merpati yang umum. Database kami yang diverifikasi pakar menyediakan gejala, protokol pencegahan, dan indikator perawatan darurat.
                </p>
            </div>
            <div class="relative group">
                <div class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
                    <span class="material-symbols-outlined text-primary/60">search</span>
                </div>
                <input id="diseaseSearch" class="w-full bg-surface-container-highest border-none rounded-xl pl-12 pr-6 py-5 text-on-surface focus:ring-0 focus:border-b-2 focus:border-primary transition-all font-body placeholder:text-outline-variant" placeholder="Cari berdasarkan nama penyakit..." type="text"/>
            </div>
        </div>
    </section>

    <!-- Catalog Grid -->
    <div id="catalogGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($penyakit_list as $p): ?>
        <article class="disease-card flex flex-col bg-surface-container-low rounded-xl overflow-hidden shadow-[0_12px_32px_rgba(80,101,42,0.04)] group" data-name="<?= strtolower($p['nama']) ?>">
            <div class="relative h-56 overflow-hidden">
                <img alt="<?= $p['nama'] ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBno_GorHUOZCbEhfr7Lo1uhdJq-SLT0TnvxLQX_RE9aOmb8ElqYi2x2btsTRsJVQlRNKj-_v0u3wuFq8K2o6bUWbxl2qr8MBmfK9YSXqsrVMOYEnsnkcq4Et6VHsvZCdHLiLOr-tSuAcYhI2ppdyOKu6_w9d4Bikb_1EJoSzv0oTxi-0SSnW-SvC7-vDQTvLImEF0J6skzmx8JQgdHTcR4bkIaFssEHJEp3IhnmUL1F6aPB_bs6obK3huT2LnbO3KxJ_WMODJesB2A"/>
            </div>
            <div class="p-6 flex flex-col flex-grow bg-surface-container-lowest mx-3 -mt-8 relative rounded-xl shadow-sm">
                <h3 class="text-xl font-headline font-extrabold text-primary mb-2"><?= $p['nama'] ?></h3>
                <p class="text-sm text-on-surface-variant line-clamp-3 mb-6 leading-relaxed">
                    <?= $p['deskripsi'] ?>
                </p>
                <div class="mt-auto pt-4 border-t border-surface-container-high">
                    <h4 class="text-xs font-bold text-primary uppercase mb-2">Solusi:</h4>
                    <p class="text-xs text-on-surface-variant line-clamp-2 mb-4"><?= $p['solusi'] ?></p>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-outline uppercase tracking-tighter italic">ID: <?= $p['id'] ?></span>
                        <button onclick="alert('Detail: <?= addslashes($p['deskripsi']) ?>\n\nPencegahan:\n<?= addslashes($p['pencegahan']) ?>')" class="text-primary font-headline font-bold text-sm flex items-center gap-1 hover:gap-2 transition-all">
                            Lihat Selengkapnya <span class="material-symbols-outlined text-base">arrow_forward</span>
                        </button>
                    </div>
                </div>
            </div>
        </article>
        <?php endforeach; ?>
    </div>
</main>

<script>
    document.getElementById('diseaseSearch').addEventListener('input', function(e) {
        const search = e.target.value.toLowerCase();
        document.querySelectorAll('.disease-card').forEach(card => {
            const name = card.getAttribute('data-name');
            if (name.includes(search)) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
