<?php
$page_title = "Tentang Kami";
include 'includes/header.php';
?>

<main class="pt-20">
    <!-- Hero Section: Editorial Design -->
    <section class="relative min-h-[716px] flex items-center overflow-hidden bg-surface py-20">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="z-10">
                <span class="text-secondary font-bold tracking-widest text-xs uppercase mb-4 block">Inisiatif Riset Avian</span>
                <h1 class="font-headline text-6xl md:text-7xl text-primary leading-tight mb-8 tracking-tighter">
                    Menggabungkan Sains <br/>dengan <span class="italic text-primary-container">Vitalitas Avian.</span>
                </h1>
                <p class="text-on-surface-variant text-xl max-w-xl leading-relaxed font-body">
                    Clinical Vitality mewakili pergeseran paradigma dalam perawatan kesehatan merpati, menggunakan logika diagnostik tingkat lanjut untuk memberikan wawasan berbasis riset yang instan bagi peternak dan dokter hewan.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] rounded-xl overflow-hidden shadow-2xl transform rotate-2">
                    <img class="w-full h-full object-cover" alt="Racing pigeon portrait" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDcLqOxJAy3AG3KSF4PmQKnEg9CZSDYLnkSzZ4aRuE9_rXwfqPDvIrvhcuc5cmBpDhhxVs0wfpdrIzLQTTVtGP5HajKltKJ9bvn0tegsnn-5h1XDixMxZOeSw58skiilwO4CsoXNAHDRuzn9tJFt6jjuPlvncRqV6O7hYbKetwaT6Re6GXtKr8bBmbOlwt_PqArPubi4VJ_tzbiuTKTA10hlE_hpup-gdZYt0LhGddvyLzT3Sf9IrwNwlzIu6cSd2Fmj9bGYQO1iLtk"/>
                </div>
                <div class="absolute -bottom-8 -left-8 bg-surface-container-lowest p-8 rounded-xl shadow-xl max-w-xs border border-outline-variant/10">
                    <p class="font-headline italic text-primary-container text-lg">"The health of the flock is the foundation of every great avian legacy."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-24 bg-surface-container-low">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-7 bg-surface-container-lowest p-12 rounded-xl shadow-sm">
                    <h2 class="font-headline text-4xl text-primary mb-6">Misi Kami</h2>
                    <p class="text-on-surface-variant text-lg leading-relaxed mb-6">
                        Memberdayakan penggemar merpati dan peneliti klinis dengan platform diagnostik cerdas yang menjembatani kesenjangan antara observasi dan tindakan klinis. Kami berupaya mengurangi tingkat kematian burung melalui deteksi dini dan analisis gejala yang tepat.
                    </p>
                    <div class="h-1 w-24 bg-secondary-container rounded-full"></div>
                </div>
                <div class="md:col-span-5 flex items-end">
                    <div class="bg-primary p-12 rounded-xl text-on-primary shadow-xl">
                        <h2 class="font-headline text-3xl mb-4">Visi</h2>
                        <p class="opacity-90 leading-relaxed">
                            Dunia di mana setiap pemilik burung memiliki akses ke logika diagnostik tingkat profesional, membina komunitas perawat yang terinformasi dan berdedikasi pada standar kesejahteraan unggas tertinggi.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works -->
    <section class="py-24 bg-surface">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16">
                <h2 class="font-headline text-5xl text-primary mb-4">Ketelitian Diagnostik</h2>
                <p class="text-on-surface-variant text-lg">Mesin ilmiah yang menggerakkan Clinical Vitality</p>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="group">
                    <div class="w-16 h-16 rounded-full bg-secondary-container flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-on-secondary-fixed-variant">clinical_notes</span>
                    </div>
                    <h3 class="font-headline text-2xl mb-4 text-primary">Observasi</h3>
                    <p class="text-on-surface-variant leading-relaxed">
                        Pengguna mengamati burung mereka dan mencatat anomali fisiologis atau perilaku ke dalam basis data penelitian kami yang aman.
                    </p>
                </div>
                <div class="bg-surface-container p-8 rounded-xl border-l-4 border-tertiary relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-tertiary opacity-10">
                        <span class="material-symbols-outlined text-8xl">rule</span>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary">priority_high</span>
                    </div>
                    <h3 class="font-headline text-2xl mb-4 text-primary">Aturan Forward Chaining</h3>
                    <p class="text-on-surface-variant leading-relaxed relative z-10">
                        Sistem kami menggunakan pendekatan berbasis data, mencocokkan gejala yang diamati dengan basis pengetahuan yang telah divalidasi untuk menentukan patologi yang paling mungkin.
                    </p>
                </div>
                <div class="group">
                    <div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                    <h3 class="font-headline text-2xl mb-4 text-primary">Analisis Probabilitas</h3>
                    <p class="text-on-surface-variant leading-relaxed">
                        Hasil disampaikan dengan skor keyakinan tinggi, memetakan gejala terhadap pola klinis yang diketahui untuk penyakit avian.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-32 relative overflow-hidden bg-primary">
        <div class="max-w-4xl mx-auto px-8 relative z-10 text-center text-on-primary">
            <h2 class="font-headline text-4xl mb-8 leading-tight">Join our research network or consult with our avian specialists.</h2>
            <div class="flex flex-wrap justify-center gap-4">
                <button class="bg-surface-container-lowest text-primary px-10 py-4 rounded-xl font-bold shadow-lg hover:bg-primary-fixed transition-colors">Contact Veterinarian</button>
                <button class="border border-on-primary/30 text-on-primary px-10 py-4 rounded-xl font-bold hover:bg-white/10 transition-colors">Bird Care Guide</button>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
