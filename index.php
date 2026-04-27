<?php
$page_title = "Beranda";
include 'includes/header.php';
?>

<main class="pt-20">
    <!-- Hero Section -->
    <section class="relative min-h-[921px] flex items-center overflow-hidden">
        <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            <div class="lg:col-span-7 z-10">
                <span class="inline-block px-4 py-1.5 mb-6 rounded-full bg-secondary-container text-on-secondary-container text-sm font-bold tracking-wider uppercase font-label">
                    Diagnosa Avian Pakar
                </span>
                <h1 class="text-6xl lg:text-7xl font-bold leading-[1.1] text-primary mb-8 -tracking-tight font-headline">
                    Perawatan Presisi untuk <span class="italic text-primary-container">Teman Avian Anda.</span>
                </h1>
                <p class="text-xl text-on-surface-variant max-w-xl mb-10 leading-relaxed font-body">
                    Menggabungkan riset klinis tingkat tinggi dengan pendekatan yang ramah untuk memberikan penilaian kesehatan paling akurat bagi merpati Anda. Karena setiap detak sayap sangat berarti.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="konsultasi.php" class="px-8 py-4 rounded-xl bg-gradient-to-br from-primary to-primary-container text-white font-bold text-lg shadow-lg shadow-primary/20 hover:scale-[1.02] transition-transform font-label text-center">
                        Mulai Konsultasi
                    </a>
                    <a href="tentang.php" class="px-8 py-4 rounded-xl border border-outline-variant text-primary font-bold text-lg hover:bg-surface-container transition-colors font-label text-center">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>
            <div class="lg:col-span-5 relative">
                <div class="relative w-full aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl">
                    <img class="w-full h-full object-cover" alt="Close-up portrait of a healthy racing pigeon" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDeCsyr8v1qygpBLntQhNqovXnYu0rL-AeB7fI0DMvTy4mz256WYKz62rjBGKbr6GE7H9p3rZp1oM_TzPK87jbr41WIrivevBVzNqYO_AMIrxarDWOsfcGAL2IxfuLo6ZWXapqyX4rspkWhfErdo97IHyhF-0dbz_jFl_r1WKFZVm6sUc1qkr5Aa76DijWQA93A1Hji-4Fuhczl3yi1mY8HDqhxP1a9D4OoUXRLAYVaeIJL-MHrIxGp4sGg0UMp7XacAKJlfld4SW5w"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-primary/30 to-transparent"></div>
                </div>
                <!-- Floating Diagnostic Card -->
                <div class="absolute -bottom-8 -left-8 p-6 bg-surface-container-lowest rounded-2xl shadow-xl border border-white/50 backdrop-blur-md max-w-[240px]">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-full bg-secondary-container flex items-center justify-center">
                            <span class="material-symbols-outlined text-secondary">monitor_heart</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-on-surface-variant font-label">STATUS VITAL</p>
                            <p class="text-sm font-bold text-primary font-body">Kesehatan Optimal</p>
                        </div>
                    </div>
                    <div class="w-full h-2 bg-surface-container rounded-full overflow-hidden">
                        <div class="w-[92%] h-full bg-primary rounded-full shadow-[0_0_8px_rgba(9,72,81,0.5)]"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Background Decorative Elements -->
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-primary-fixed-dim/20 blur-[120px] rounded-full -z-10"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-secondary-fixed/20 blur-[100px] rounded-full -z-10"></div>
    </section>

    <!-- Benefits Bento Grid -->
    <section class="py-32 bg-surface-container-low">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <h2 class="text-4xl lg:text-5xl font-bold text-primary mb-6 font-headline">Mengapa Diagnosa Dini Penting?</h2>
                <p class="text-lg text-on-surface-variant font-body">Ketepatan dalam mendeteksi gejala awal dapat menyelamatkan nyawa dan menjaga performa burung kesayangan Anda.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Feature 1: Large Asymmetric Card -->
                <div class="md:col-span-8 bg-surface-container-lowest p-10 rounded-[2.5rem] flex flex-col md:flex-row gap-10 items-center border-l-4 border-secondary">
                    <div class="flex-1">
                        <div class="w-14 h-14 rounded-2xl bg-secondary-container flex items-center justify-center mb-6">
                            <span class="material-symbols-outlined text-secondary text-3xl">biotech</span>
                        </div>
                        <h3 class="text-3xl font-bold text-primary mb-4 font-headline">Akurasi Laboratorium Digital</h3>
                        <p class="text-on-surface-variant leading-relaxed mb-6 font-body">
                            Menggunakan algoritma diagnostik tingkat lanjut untuk menganalisis gejala fisik dan pola perilaku dengan tingkat presisi jurnal medis.
                        </p>
                        <a class="text-primary font-bold flex items-center gap-2 hover:gap-4 transition-all font-label" href="katalog.php">
                            Lihat Katalog Penyakit <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                    <div class="w-full md:w-1/3 aspect-square rounded-3xl overflow-hidden shadow-inner bg-surface">
                        <img class="w-full h-full object-cover opacity-60 mix-blend-multiply" alt="Microscopic view" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBA-Aud_pWeuS9suoyee0gFvkJCahVPJwgfDBYnz7LaJbDWbN0f1QMs9hZXiFCc5qfS4EtrgWPJSjRG5TQdIyfG_oD9f52TQkFsiW_MNf-MIW5itLAbyieZaC_loCwayEZrJx8v-qg5GYiZmTnmQmGLlYYAPFMYGVeZV23mIWGIXRO8qpSK7WrrDuaSxogopq84Er2OCKK7yV84jN9srWCzLRrS9NVzzXB7uzN7MvRLO4VGSNnf47qSb-6a8lK3MShmalN9PQAfS9aH"/>
                    </div>
                </div>
                <!-- Feature 2: Tall Card -->
                <div class="md:col-span-4 bg-primary text-on-primary p-10 rounded-[2.5rem] flex flex-col justify-between">
                    <div>
                        <span class="material-symbols-outlined text-5xl mb-8">speed</span>
                        <h3 class="text-2xl font-bold mb-4 font-headline">Hasil Instan</h3>
                        <p class="opacity-80 leading-relaxed font-body">
                            Dapatkan rekomendasi tindakan pertama dalam hitungan detik setelah menginput gejala yang diamati.
                        </p>
                    </div>
                    <div class="mt-8 pt-8 border-t border-primary-container">
                        <p class="text-sm font-label opacity-60 uppercase tracking-widest mb-2">Tingkat Keberhasilan</p>
                        <p class="text-4xl font-headline font-bold">98.4%</p>
                    </div>
                </div>
                <!-- Feature 3: Card -->
                <div class="md:col-span-4 bg-tertiary p-10 rounded-[2.5rem] text-white">
                    <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined">verified_user</span>
                    </div>
                    <h3 class="text-2xl font-bold mb-4 font-headline">Aman & Terpercaya</h3>
                    <p class="text-tertiary-fixed-dim font-body">Data kesehatan burung Anda dienkripsi dan hanya digunakan untuk keperluan konsultasi medis.</p>
                </div>
                <!-- Feature 4: Wide Card -->
                <div class="md:col-span-8 bg-surface-container-highest p-10 rounded-[2.5rem] flex items-center justify-between overflow-hidden relative group">
                    <div class="relative z-10 max-w-md">
                        <h3 class="text-2xl font-bold text-primary mb-4 font-headline">Konsultasi Dokter Hewan Ahli</h3>
                        <p class="text-on-surface-variant font-body">Terhubung langsung dengan spesialis avian bersertifikat untuk kasus yang memerlukan penanganan khusus.</p>
                    </div>
                    <div class="absolute -right-10 top-0 h-full w-1/2 opacity-20 group-hover:opacity-40 transition-opacity">
                        <img class="h-full w-full object-cover" alt="Medical stethoscope" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDBptKzNDkoLZkAa_nDkqdru9_GFp2Eiij-mqMMF8T0a2lOf2u6_aVbcN9IzTD26uGmve-Zll6VBUEAHdlIGnypyacKmojgQ7dLKOidzryn8DTVtI9PW5xLK4ksH2LabaGVchRccHCBrydHpXX8gTOrXReF3BbHWG0BEawWFSDFBeXlS7GEEmJWhbjcZ1Jng4sEzQ2mRJCNX63UL1jwkBg_db2Xap4C2oJoXnF22zxPEjYY30JNICgA0hwZZIrMl7T6kJ5XiItXX5G-"/>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Teaser Section -->
    <section class="py-32 bg-surface">
        <div class="max-w-7xl mx-auto px-8 flex flex-col lg:flex-row gap-20 items-center">
            <div class="lg:w-1/2">
                <h2 class="text-4xl font-bold text-primary mb-8 font-headline">Katalog Penyakit Terlengkap</h2>
                <div class="space-y-6">
                    <div class="p-6 rounded-2xl bg-surface-container hover:bg-surface-container-high transition-colors flex items-center gap-6">
                        <div class="w-4 h-16 bg-tertiary rounded-full"></div>
                        <div>
                            <h4 class="text-xl font-bold text-primary mb-1 font-headline">Masalah Pernapasan</h4>
                            <p class="text-on-surface-variant font-body">Analisis mendalam gejala pilek, sesak nafas, dan asma pada burung dara.</p>
                        </div>
                    </div>
                    <div class="p-6 rounded-2xl bg-surface-container hover:bg-surface-container-high transition-colors flex items-center gap-6">
                        <div class="w-4 h-16 bg-secondary rounded-full"></div>
                        <div>
                            <h4 class="text-xl font-bold text-primary mb-1 font-headline">Gangguan Pencernaan</h4>
                            <p class="text-on-surface-variant font-body">Pemantauan kesehatan pencernaan melalui observasi feses dan pola makan.</p>
                        </div>
                    </div>
                    <div class="p-6 rounded-2xl bg-surface-container hover:bg-surface-container-high transition-colors flex items-center gap-6">
                        <div class="w-4 h-16 bg-primary-container rounded-full"></div>
                        <div>
                            <h4 class="text-xl font-bold text-primary mb-1 font-headline">Kesehatan Bulu & Kulit</h4>
                            <p class="text-on-surface-variant font-body">Identifikasi parasit kulit dan masalah kerontokan bulu yang abnormal.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 relative">
                <div class="relative z-10 rounded-[3rem] overflow-hidden shadow-2xl">
                    <img class="w-full aspect-video object-cover" alt="Healthy pigeons" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfm1w9Au5VZ3zE9Rz1RQW6UKOcIUyqz5ULjnJEf4tquvPhgWRDAjWiHwV8BDFWex4Kr_GovjKQoW7WxIdlfy0SPIaMVYuPj_DlRlBsvWc3LP_mTe3FvGo7nRQSUilCKuvXbRDsjmeVekbgS_mQowCS3IU16Wg4i3aSX2wjODxjY8-z0XIsIi4dkppZgf_Wi7fW9ejc6hQzDsXuzj1W7V7yvCcQL9ne8ZzZOY3kI9Qr5H5u1HWaNUlYWOyghc7inLUlBD18LkKGpREM"/>
                </div>
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-secondary-container rounded-full -z-10 opacity-30"></div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 px-8">
        <div class="max-w-5xl mx-auto rounded-[3rem] bg-gradient-to-br from-primary to-primary-container p-12 lg:p-20 text-center relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-4xl lg:text-5xl font-bold text-white mb-8 font-headline">Siap Memastikan Kesehatan Burung Anda?</h2>
                <p class="text-xl text-on-primary-container mb-12 max-w-2xl mx-auto font-body">Bergabunglah dengan ribuan pemilik burung yang telah mempercayakan diagnosa kesehatan pada Klinik Merpati.</p>
                <a href="konsultasi.php" class="px-10 py-5 rounded-full bg-white text-primary font-extrabold text-xl hover:bg-primary-fixed transition-colors shadow-xl font-label inline-block">
                    Mulai Konsultasi Sekarang
                </a>
            </div>
            <!-- Abstract patterns -->
            <div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none">
                <svg class="w-full h-full" viewBox="0 0 100 100">
                    <circle cx="90" cy="10" fill="white" r="30"></circle>
                    <circle cx="10" cy="90" fill="white" r="40"></circle>
                </svg>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>
