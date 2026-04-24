<?php
require_once 'includes/functions.php';
$page_title = "Katalog Penyakit";
include 'includes/header.php';

$penyakit_list = get_all_penyakit($pdo);
$gejala_list = get_all_gejala($pdo);
?>

<main class="bg-surface text-on-surface selection:bg-primary-fixed-dim min-h-screen">
    <!-- Hero / Header Section -->
    <header class="pt-32 pb-16 px-8 max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="max-w-2xl">
                <span class="text-primary font-bold tracking-widest text-xs uppercase mb-4 block">Arsip Diagnostik</span>
                <h1 class="text-5xl md:text-6xl font-headline font-bold text-primary mb-6 -tracking-tighter">Katalog Penyakit Avian</h1>
                <p class="text-lg text-on-surface-variant leading-relaxed opacity-80">
                    Database komprehensif mengenai kondisi kesehatan merpati, gejala klinis, dan langkah pencegahan awal untuk pemeliharaan yang profesional.
                </p>
            </div>
            <!-- Search Interface -->
            <div class="w-full md:w-96">
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline-variant group-focus-within:text-primary transition-colors">search</span>
                    <input id="catalogSearch" class="w-full pl-12 pr-4 py-4 bg-surface-container-highest border-none rounded-xl focus:ring-2 focus:ring-primary-fixed transition-all text-on-surface placeholder:text-outline" placeholder="Cari..." type="text"/>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content: Disease Catalog -->
    <main class="px-8 pb-24 max-w-7xl mx-auto">
        <!-- Filter Tabs -->
        <div class="flex gap-4 mb-12 overflow-x-auto no-scrollbar pb-2">
            <button id="btnInfoPenyakit" class="px-6 py-2 bg-primary text-on-primary rounded-full text-sm font-semibold whitespace-nowrap transition-all shadow-sm">Info Penyakit</button>
            <button id="btnInfoGejala" class="px-6 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface-variant rounded-full text-sm font-medium whitespace-nowrap transition-all shadow-sm">Info Gejala</button>
        </div>

        <!-- Disease Grid -->
        <div id="diseaseGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($penyakit_list as $p): ?>
            <article class="disease-card bg-surface-container-lowest rounded-xl p-8 flex flex-col relative overflow-hidden group shadow-sm shadow-cyan-900/5" data-name="<?= strtolower($p['nama']) ?>">
                <div class="absolute top-0 left-0 w-1 h-full bg-secondary"></div>
                <div class="flex justify-between items-start mb-6">
                    <span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold tracking-wide">Info Penyakit</span>
                    <span class="material-symbols-outlined text-outline-variant">microbiology</span>
                </div>
                <h3 class="text-2xl font-headline font-bold text-primary mb-3"><?= $p['nama'] ?></h3>
                <p class="text-on-surface-variant text-sm leading-relaxed mb-6 flex-grow">
                    <?= $p['deskripsi'] ?>
                </p>
                <div class="space-y-3 mb-8">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-secondary text-sm mt-0.5">check_circle</span>
                        <span class="text-xs text-on-surface font-medium"><?= substr($p['solusi'], 0, 50) ?>...</span>
                    </div>
                </div>
                <button onclick="alert('Deskripsi:\n<?= addslashes($p['deskripsi']) ?>\n\nSolusi:\n<?= addslashes($p['solusi']) ?>\n\nPencegahan:\n<?= addslashes($p['pencegahan']) ?>')" class="flex items-center gap-2 text-primary font-bold text-sm group-hover:gap-4 transition-all">
                    Baca Selengkapnya
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Symptoms Grid (Hidden by default) -->
        <div id="symptomGrid" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($gejala_list as $g): ?>
            <div class="symptom-card bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm hover:border-primary/30 transition-all group" data-name="<?= strtolower($g['nama']) ?>">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-lg bg-primary-fixed flex items-center justify-center text-primary font-bold text-sm group-hover:bg-primary group-hover:text-on-primary transition-colors">
                        <?= $g['id'] ?>
                    </div>
                    <span class="font-medium text-on-surface text-sm"><?= $g['nama'] ?></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- Professional Support Section -->
    <section class="bg-surface-container py-24">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div class="relative">
                <div class="aspect-[4/5] bg-surface-container-highest rounded-2xl overflow-hidden shadow-2xl">
                    <img alt="Penelitian laboratorium" class="w-full h-full object-cover grayscale mix-blend-multiply opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHUrfQM2NJzzNNAvpFYZU5ypsPRMWdvYGS2rTbzA4WDtfrHM3GDZIvjJ5q-m4vYZE82bMJsibH0sCs1EpWc5MnS0t8dKvrpBZzvVJZyhAM4if4SkiJJBSKvdiqNG3x9BVTRyGu6BFJU8NYxJVoOG_yXXsA8jZQP5S9hNwWRWa4b5JpLYXg4AHljdMS1enbjTHNCmIgNLItNcn0hUzx4EFLj7KPm8WYqlL3w8ZmFBDZu2jR14Ynf-enw9OmAPFeLIr2LEuse-dWQqBZ"/>
                </div>
                <div class="absolute -bottom-8 -right-8 p-8 bg-primary rounded-2xl text-on-primary max-w-xs shadow-xl">
                    <p class="font-headline italic text-lg leading-snug">"Deteksi dini adalah kunci keselamatan koloni merpati Anda."</p>
                    <p class="mt-4 text-xs font-bold uppercase tracking-widest opacity-70">— Dr. Hendrik, Spesialis Avian</p>
                </div>
            </div>
            <div class="space-y-8">
                <h2 class="text-4xl font-headline font-bold text-primary">Butuh Diagnosa Profesional?</h2>
                <p class="text-lg text-on-surface-variant leading-relaxed">
                    Katalog ini hanyalah referensi awal. Untuk akurasi medis yang tepat, kami menyarankan konsultasi langsung dengan dokter hewan spesialis burung.
                </p>
                <div class="flex flex-col gap-4">
                    <div class="p-6 bg-surface-container-lowest rounded-xl flex items-center gap-6 group hover:bg-primary transition-all cursor-pointer">
                        <div class="w-12 h-12 bg-secondary-container rounded-full flex items-center justify-center group-hover:bg-on-primary">
                            <span class="material-symbols-outlined text-on-secondary-container group-hover:text-primary">video_call</span>
                        </div>
                        <div>
                            <h4 class="font-bold group-hover:text-on-primary">Telekonsultasi Cepat</h4>
                            <p class="text-sm text-on-surface-variant group-hover:text-on-primary/80">Hubungi dokter dalam 15 menit melalui video.</p>
                        </div>
                    </div>
                    <div class="p-6 bg-surface-container-lowest rounded-xl flex items-center gap-6 group hover:bg-primary transition-all cursor-pointer">
                        <div class="w-12 h-12 bg-tertiary-fixed rounded-full flex items-center justify-center group-hover:bg-on-primary">
                            <span class="material-symbols-outlined text-on-tertiary-fixed-variant group-hover:text-primary">lab_research</span>
                        </div>
                        <div>
                            <h4 class="font-bold group-hover:text-on-primary">Analisis Lab Mandiri</h4>
                            <p class="text-sm text-on-surface-variant group-hover:text-on-primary/80">Kirim sampel kotoran untuk pengujian PCR.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
    const btnInfoPenyakit = document.getElementById('btnInfoPenyakit');
    const btnInfoGejala = document.getElementById('btnInfoGejala');
    const diseaseGrid = document.getElementById('diseaseGrid');
    const symptomGrid = document.getElementById('symptomGrid');
    const catalogSearch = document.getElementById('catalogSearch');

    let currentTab = 'penyakit';

    btnInfoPenyakit.addEventListener('click', () => {
        currentTab = 'penyakit';
        diseaseGrid.classList.remove('hidden');
        symptomGrid.classList.add('hidden');

        btnInfoPenyakit.className = 'px-6 py-2 bg-primary text-on-primary rounded-full text-sm font-semibold whitespace-nowrap transition-all shadow-sm';
        btnInfoGejala.className = 'px-6 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface-variant rounded-full text-sm font-medium whitespace-nowrap transition-all shadow-sm';

        filterItems();
    });

    btnInfoGejala.addEventListener('click', () => {
        currentTab = 'gejala';
        diseaseGrid.classList.add('hidden');
        symptomGrid.classList.remove('hidden');

        btnInfoGejala.className = 'px-6 py-2 bg-primary text-on-primary rounded-full text-sm font-semibold whitespace-nowrap transition-all shadow-sm';
        btnInfoPenyakit.className = 'px-6 py-2 bg-surface-container hover:bg-surface-container-high text-on-surface-variant rounded-full text-sm font-medium whitespace-nowrap transition-all shadow-sm';

        filterItems();
    });

    catalogSearch.addEventListener('input', filterItems);

    function filterItems() {
        const search = catalogSearch.value.toLowerCase();
        if (currentTab === 'penyakit') {
            document.querySelectorAll('.disease-card').forEach(card => {
                const name = card.getAttribute('data-name');
                card.style.display = name.includes(search) ? 'flex' : 'none';
            });
        } else {
            document.querySelectorAll('.symptom-card').forEach(card => {
                const name = card.getAttribute('data-name');
                card.style.display = name.includes(search) ? 'block' : 'none';
            });
        }
    }
</script>

<?php include 'includes/footer.php'; ?>
