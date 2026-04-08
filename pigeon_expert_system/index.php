<?php include 'includes/header.php'; ?>

<!-- Hero Section: Editorial Asymmetry -->
<section class="relative pt-32 pb-20 px-8 max-w-screen-2xl mx-auto overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
        <div class="lg:col-span-6 space-y-8 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-xs font-bold tracking-widest uppercase font-label">
                <span class="material-symbols-outlined text-sm">verified</span> Precision Avian Care
            </div>
            <h1 class="text-5xl lg:text-7xl font-headline font-extrabold tracking-tight text-on-background leading-[1.1]">
                Professional <span class="text-primary">Diagnostic</span> Intelligence.
            </h1>
            <p class="text-lg text-on-surface-variant leading-relaxed max-w-xl">
                Sistem pakar klinis yang dirancang khusus untuk kesehatan burung merpati. Menggabungkan observasi naturalis dengan algoritma presisi untuk deteksi dini penyakit avian.
            </p>
            <div class="flex flex-wrap gap-4 pt-4">
                <a href="konsultasi.php" class="px-8 py-4 bg-primary text-on-primary text-lg font-headline font-bold rounded-xl shadow-lg hover:bg-primary-dim transition-all active:scale-95 text-center">
                    Mulai Diagnosa
                </a>
                <a href="#" class="px-8 py-4 bg-secondary-container text-on-secondary-container text-lg font-headline font-bold rounded-xl hover:bg-secondary-fixed-dim transition-all text-center">
                    Pelajari Metode
                </a>
            </div>
        </div>
        <div class="lg:col-span-6 relative">
            <div class="relative rounded-3xl overflow-hidden shadow-[0_32px_64px_rgba(80,101,42,0.12)] aspect-[4/5] lg:aspect-square">
                <img class="w-full h-full object-cover" alt="Racing Pigeon" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCCt82ejNyGS9vUYEY9XLdhWwKGEvHdojlRA1wM-faZUrSr16UnI09UeS5I1y95zaOr1LAeIkp1klQLjjV_nz0E4nVIz1iUxqjWSOIG3a-bhMIy_P5ogHTy3G__NCr3fkb4KDXscALOcqI2cuzE3Cm79vSmsi68octL3t7lip40CJRkGacYQnnlNFUDjseA-9gRbgT4SOCoQkoVYSj_6Fbx6cc2MPtQbrjkLJ3on3KMRexUN9GICOY-HsQ_VzXOWRoePR3d4s5MYjGg"/>
                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
            </div>
            <!-- Float Card -->
            <div class="absolute -bottom-8 -left-8 bg-surface-container-lowest p-6 rounded-2xl shadow-xl max-w-[240px] border border-outline-variant/10">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">health_metrics</span>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">Live Accuracy</span>
                </div>
                <div class="text-3xl font-headline font-black text-primary">98.4%</div>
                <p class="text-xs text-on-surface-variant mt-1">Diagnostic precision across 10 common avian pathologies.</p>
            </div>
        </div>
    </div>
</section>

<!-- Method: Forward Chaining Section -->
<section class="bg-surface-container-low py-24 px-8">
    <div class="max-w-screen-2xl mx-auto">
        <div class="mb-16 max-w-2xl">
            <h2 class="text-3xl font-headline font-extrabold text-on-background mb-6">Forward Chaining Method</h2>
            <p class="text-on-surface-variant leading-relaxed">
                Kami menggunakan pendekatan <span class="font-bold text-on-background italic">Data-Driven Inference</span>. Proses dimulai dari observasi gejala spesifik yang dialami merpati Anda, yang kemudian diolah melalui mesin inferensi untuk mencapai kesimpulan diagnosis yang akurat.
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Step 1 -->
            <div class="bg-surface-container-lowest p-10 rounded-2xl space-y-6">
                <div class="text-primary-dim opacity-20 text-6xl font-black">01</div>
                <h3 class="text-xl font-headline font-bold text-on-background">Identifikasi Gejala</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">Input data klinis berupa kondisi fisik, kotoran, dan perilaku terbang merpati melalui checklist terstandarisasi.</p>
            </div>
            <!-- Step 2 -->
            <div class="bg-surface-container-lowest p-10 rounded-2xl space-y-6">
                <div class="text-primary-dim opacity-20 text-6xl font-black">02</div>
                <h3 class="text-xl font-headline font-bold text-on-background">Mesin Inferensi</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">Algoritma mengevaluasi fakta terhadap basis pengetahuan (Knowledge Base) yang disusun oleh pakar ornitologi.</p>
            </div>
            <!-- Step 3 -->
            <div class="bg-surface-container-lowest p-10 rounded-2xl space-y-6">
                <div class="text-primary-dim opacity-20 text-6xl font-black">03</div>
                <h3 class="text-xl font-headline font-bold text-on-background">Konfirmasi Diagnosis</h3>
                <p class="text-on-surface-variant text-sm leading-relaxed">Sistem menyimpulkan kemungkinan penyakit dan memberikan rekomendasi protokol pengobatan yang tepat.</p>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Kami: Bento Grid Layout -->
<section class="py-24 px-8 max-w-screen-2xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 lg:grid-rows-2 gap-6 h-auto lg:h-[600px]">
        <div class="lg:col-span-2 lg:row-span-2 bg-primary rounded-3xl p-12 text-on-primary flex flex-col justify-end relative overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover mix-blend-overlay opacity-30" alt="Pathology" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1ETc6_R7MJ1ij82u69vFoI68a3R2Hgt_fzYpoFimJr9CWwTVIhhANt9G2U842zVJ5UtLnyaTYtH5WxI9H5uaqA7N6-hd8OwGP90dOsF9PGHKXAQ9vAB89815soMFFRAQgulSqxXTtIZCT0FLq7X5fT5x5og5QDdL7DlqaGmdiuSEt49G6C-Ug70ABD3xXU78DkJlR3R8F0GFL7qBvhq7IRxacfASVVsx2zAbGjn0wfJGF9q7qmMtJfsh3dvtFbwi3m7K6MCVamrLW"/>
            <h2 class="text-4xl font-headline font-extrabold mb-6 relative z-10">Tentang Kami</h2>
            <p class="text-lg font-light relative z-10 leading-relaxed max-w-md">
                Didirikan oleh koalisi pakar kesehatan unggas dan pengembang AI, The Clinical Naturalist hadir untuk mendemokrasikan akses kesehatan merpati bagi peternak dan pehobi di seluruh dunia.
            </p>
        </div>
        <div class="lg:col-span-2 bg-secondary rounded-3xl p-10 text-on-secondary flex flex-col justify-center">
            <h3 class="text-2xl font-headline font-bold mb-4">Visi Presisi</h3>
            <p class="opacity-80">Menjadi standar emas dalam diagnostik penyakit burung melalui integrasi teknologi pakar yang mudah diakses.</p>
        </div>
        <div class="bg-surface-container-high rounded-3xl p-8 flex flex-col justify-between">
            <span class="material-symbols-outlined text-4xl text-primary">biotech</span>
            <div class="text-sm font-bold uppercase tracking-tighter text-on-surface-variant">Advanced Research</div>
        </div>
        <div class="bg-surface-container-high rounded-3xl p-8 flex flex-col justify-between">
            <span class="material-symbols-outlined text-4xl text-primary">diversity_1</span>
            <div class="text-sm font-bold uppercase tracking-tighter text-on-surface-variant">Community Expert</div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
