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
                    <h3 class="font-headline text-2xl mb-4 text-primary">Observation</h3>
                    <p class="text-on-surface-variant leading-relaxed">
                        Users observe their birds and log physiological or behavioral anomalies into our secure research database.
                    </p>
                </div>
                <div class="bg-surface-container p-8 rounded-xl border-l-4 border-tertiary relative overflow-hidden">
                    <div class="absolute top-4 right-4 text-tertiary opacity-10">
                        <span class="material-symbols-outlined text-8xl">rule</span>
                    </div>
                    <div class="w-12 h-12 rounded-full bg-tertiary-fixed flex items-center justify-center mb-6">
                        <span class="material-symbols-outlined text-tertiary">priority_high</span>
                    </div>
                    <h3 class="font-headline text-2xl mb-4 text-primary">The Forward Chaining Rule</h3>
                    <p class="text-on-surface-variant leading-relaxed relative z-10">
                        Our system utilizes a data-driven approach, matching observed symptoms against a validated knowledge base to determine the most likely pathology.
                    </p>
                </div>
                <div class="group">
                    <div class="w-16 h-16 rounded-full bg-primary-fixed flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined text-primary">analytics</span>
                    </div>
                    <h3 class="font-headline text-2xl mb-4 text-primary">Probability Analysis</h3>
                    <p class="text-on-surface-variant leading-relaxed">
                        Results are delivered with high confidence scores, mapping symptoms against known clinical patterns for avian ailments.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="py-24 bg-surface-container-lowest">
        <div class="max-w-7xl mx-auto px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-8">
                <div class="max-w-2xl">
                    <h2 class="font-headline text-5xl text-primary mb-6">Dewan Ilmiah</h2>
                    <p class="text-on-surface-variant text-xl">Riset kami dipimpin oleh spesialis dalam patologi avian dan informatika veteriner, memastikan setiap baris kode melayani tujuan biologis.</p>
                </div>
                <button class="text-primary font-bold flex items-center gap-2 group">
                    Temui Seluruh Tim Riset
                    <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="group">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden mb-6 bg-surface-container">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Dr. Elena Vos" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAmz0Yx7aaOM3voGbj9JqfkJGi30tISk8AST7a0iUsXVdAaOH-oA--NzaZgTzdsgNQR_B1-XfIN2XzYBiAdS_1g5CJvqpIij7sVnU9H3C5Smd2saIwldA-JQhVvjxlE-bEi_GpUIs2HTYKT9J_TrOp8JG_CmtIN0hW85z-GtMC-tJOg9qVOdaPKQrdchcKkksGXeRDaG_WZCGyMR7-qzjvfPkJ248a7RJZ8ksxkwR5bCZNRMfyDD2BxcJNluHKqvVlBI7N32aeWt4Zs"/>
                    </div>
                    <h4 class="font-headline text-xl text-primary">Dr. Elena Vos</h4>
                    <p class="text-secondary font-medium text-sm uppercase tracking-wide">Ketua Patologi</p>
                </div>
                <div class="group pt-12 md:pt-24">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden mb-6 bg-surface-container">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Dr. Marcus Thorne" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCqKThEy81wMuT9nDVacQK4q72L8hUjxPOYATx9-RG-bsrfWKRRFJH6miqjPtEvLtZjww2WJ5Oc6rzKG7AOr6j86g-H4PCpUVSytfH4aWzDByMUxtSXZoVJ5ZFmovmsOxh3reCEE6lBnXkSTU-1d35BFlabe-MGbdqmLDc7QIA9JuAOo0ZNca6Rs44FkdhdGJhRX8iPcMHZDbs-PYHYiYbaw_PZ_aEuHVL0HNvoRdhkPC6IfO7wBl75mNbdWA2C0GKOu-elyg1oE71U"/>
                    </div>
                    <h4 class="font-headline text-xl text-primary">Dr. Marcus Thorne</h4>
                    <p class="text-secondary font-medium text-sm uppercase tracking-wide">Kepala Informatika</p>
                </div>
                <div class="group pt-0 md:pt-12">
                    <div class="aspect-[3/4] rounded-xl overflow-hidden mb-6 bg-surface-container">
                        <img class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-500" alt="Sarah Jenkins" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBoj26AvtHHEdqDGOxTuSIDMWkMnC5IUy6qaHDQbabvDvm6Q6xtnoOFYvCOccbT7Gm16j2DZDEY9iyI6fCgGdgAXDeiK3LUSzKpJ9yvKbCpJOze7mk-FevfCL-VEQokJSDU_M0fIBB_u277y29U1wgtwaHzXE1lv5v-DqHbu_Uxi2UV0VcL4Z80wmai4g8FmOIJmEpyCvZA2y0gU6TF1yap8aPXZfK2kVu4Rh1fUaIOoVE5rKEQBWIeci38-1qofhbd7mAacWnpjsTq"/>
                    </div>
                    <h4 class="font-headline text-xl text-primary">Sarah Jenkins</h4>
                    <p class="text-secondary font-medium text-sm uppercase tracking-wide">Direktur Kesejahteraan</p>
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
