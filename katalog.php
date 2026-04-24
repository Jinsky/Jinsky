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
                <button onclick="openDiseaseModal('<?= addslashes($p['nama']) ?>', '<?= addslashes(nl2br($p['deskripsi'])) ?>', '<?= addslashes(nl2br($p['solusi'])) ?>', '<?= addslashes(nl2br($p['pencegahan'])) ?>')" class="flex items-center gap-2 text-primary font-bold text-sm group-hover:gap-4 transition-all">
                    Baca Selengkapnya
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </button>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Disease Detail Modal -->
        <div id="diseaseModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center p-4 z-[100]">
            <div class="bg-surface rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-hidden flex flex-col shadow-2xl">
                <div class="p-8 border-b border-outline-variant/10 flex justify-between items-center bg-primary text-on-primary">
                    <h2 id="modalDiseaseName" class="text-3xl font-headline font-bold">Detail Penyakit</h2>
                    <button onclick="closeDiseaseModal()" class="material-symbols-outlined hover:rotate-90 transition-transform">close</button>
                </div>
                <div class="p-8 overflow-y-auto space-y-8">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-widest text-primary mb-3">Deskripsi</h4>
                        <p id="modalDiseaseDesc" class="text-on-surface-variant leading-relaxed"></p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-secondary mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">medical_services</span> Solusi
                            </h4>
                            <p id="modalDiseaseSol" class="text-xs text-on-surface-variant leading-relaxed"></p>
                        </div>
                        <div class="bg-surface-container-low p-6 rounded-xl border border-outline-variant/10">
                            <h4 class="text-sm font-bold uppercase tracking-widest text-tertiary mb-3 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">shield</span> Pencegahan
                            </h4>
                            <p id="modalDiseasePrev" class="text-xs text-on-surface-variant leading-relaxed"></p>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-surface-container-highest flex justify-end">
                    <button onclick="closeDiseaseModal()" class="px-8 py-3 bg-primary text-on-primary rounded-xl font-bold hover:opacity-90 transition-opacity">Tutup</button>
                </div>
            </div>
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

</main>

<script>
    function openDiseaseModal(name, desc, sol, prev) {
        document.getElementById('modalDiseaseName').innerText = name;
        document.getElementById('modalDiseaseDesc').innerHTML = desc;
        document.getElementById('modalDiseaseSol').innerHTML = sol;
        document.getElementById('modalDiseasePrev').innerHTML = prev;
        document.getElementById('diseaseModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDiseaseModal() {
        document.getElementById('diseaseModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

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
