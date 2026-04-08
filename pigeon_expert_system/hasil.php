<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: konsultasi.php');
    exit;
}

$nama_merpati = $_POST['nama_merpati'] ?? 'Unnamed';
$selected_gejala = $_POST['gejala'] ?? [];

$diagnosis = get_diagnosa($pdo, $selected_gejala);

if ($diagnosis) {
    save_diagnosa($pdo, $nama_merpati, $diagnosis['id'], $selected_gejala, $diagnosis['confidence']);
}

include 'includes/header.php';
?>

<main class="pt-24 pb-20 px-6 max-w-screen-xl mx-auto">
    <!-- Header Section -->
    <header class="mb-12">
        <span class="inline-block px-4 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-semibold mb-4">
            Analysis Complete
        </span>
        <h1 class="text-4xl md:text-5xl font-black tracking-tight text-primary mb-4 leading-none">Diagnosis Result</h1>
        <p class="text-on-surface-variant max-w-2xl text-lg leading-relaxed">
            Identitas Merpati: <strong><?= htmlspecialchars($nama_merpati) ?></strong><br>
            Berdasarkan analisis forward chaining dari tanda-tanda klinis yang diamati.
        </p>
    </header>

    <?php if ($diagnosis): ?>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Result Main Card -->
        <div class="lg:col-span-8 space-y-8">
            <section class="bg-surface-container-low rounded-xl p-8 relative overflow-hidden border border-primary/10">
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
                        <div>
                            <h2 class="text-3xl font-extrabold text-on-surface mb-2"><?= $diagnosis['nama'] ?></h2>
                            <div class="flex items-center gap-2 text-on-surface-variant">
                                <span class="material-symbols-outlined text-primary">verified</span>
                                <span class="text-sm font-semibold tracking-wide uppercase">High Probability Factor</span>
                            </div>
                        </div>
                        <div class="flex flex-col items-center justify-center p-6 bg-surface-container-lowest rounded-xl shadow-[0_12px_32px_rgba(80,101,42,0.08)] min-w-[140px]">
                            <span class="text-4xl font-black text-primary"><?= $diagnosis['confidence'] ?>%</span>
                            <span class="text-[10px] font-bold text-on-surface-variant tracking-widest uppercase mt-1">Confidence</span>
                        </div>
                    </div>

                    <div class="bg-surface-container-lowest rounded-lg p-6 mb-8">
                        <h3 class="text-sm font-bold text-primary mb-3 uppercase tracking-wider">Deskripsi Penyakit</h3>
                        <p class="text-on-surface leading-relaxed text-lg">
                            <?= nl2br($diagnosis['deskripsi']) ?>
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-4 bg-surface-container-high rounded-lg flex gap-4 items-start">
                            <span class="material-symbols-outlined text-primary">medical_services</span>
                            <div>
                                <h4 class="font-bold text-sm mb-1">Status</h4>
                                <p class="text-xs text-on-surface-variant">Analisis sistem pakar menunjukkan kecocokan kuat dengan pola gejala ini.</p>
                            </div>
                        </div>
                        <div class="p-4 bg-surface-container-high rounded-lg flex gap-4 items-start">
                            <span class="material-symbols-outlined text-primary">science</span>
                            <div>
                                <h4 class="font-bold text-sm mb-1">Metode</h4>
                                <p class="text-xs text-on-surface-variant">Forward Chaining (Data-Driven Inference)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Recommendations Section -->
            <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-surface-container-lowest border-l-4 border-primary p-6 rounded-xl shadow-[0_12px_32px_rgba(80,101,42,0.08)]">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-primary">security</span>
                        <h3 class="font-extrabold text-xl">Langkah Penanganan (Solusi)</h3>
                    </div>
                    <div class="text-sm space-y-2 text-on-surface-variant">
                        <?= nl2br($diagnosis['solusi']) ?>
                    </div>
                </div>
                <div class="bg-surface-container-lowest border-l-4 border-secondary p-6 rounded-xl shadow-[0_12px_32px_rgba(80,101,42,0.08)]">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="material-symbols-outlined text-secondary">vaccines</span>
                        <h3 class="font-extrabold text-xl">Tips Pencegahan</h3>
                    </div>
                    <div class="text-sm space-y-2 text-on-surface-variant">
                        <?= nl2br($diagnosis['pencegahan']) ?>
                    </div>
                </div>
            </section>

            <!-- Warning Disclaimer -->
            <div class="bg-error-container/10 border border-error/20 p-6 rounded-xl flex items-start gap-4">
                <span class="material-symbols-outlined text-error mt-1">warning</span>
                <div>
                    <p class="text-on-error-container font-bold text-sm">Medical Disclaimer</p>
                    <p class="text-on-error-container text-sm leading-relaxed">
                        Hasil ini bersifat informatif, segera hubungi dokter hewan jika gejala memburuk. Alat ini tidak menggantikan konsultasi profesional dokter hewan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-4 space-y-6">
            <div class="bg-surface-container-low rounded-xl p-6">
                <h3 class="text-xs font-bold text-on-surface-variant uppercase tracking-widest mb-6">Expert Verification</h3>
                <div class="flex items-center gap-4 mb-6">
                    <img alt="Expert" class="w-12 h-12 rounded-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBbDvhPbuXi4H-OSE2CB3aoa-MurHwCPM8_8iBKsxm5cWyr5I0MZY2j1Ud25G8NX6aBkNx-qn8pHTDlfoRqt5t7BiDj7sNhzjpabENFWbZwaplVhtJVnC7DbHuyeCxJrTPegac4I23iLxx5YQBEDLuXDZE9NddXzKVMGA1lI0-cAoF_vHiE1RuUN2_enM1lWF_Icn4uXTwmv6GMBDi1cw24kaeU5sPln23OXZOnSXarNxPomT9aXNE6YxzW_2LvRDvjOullGLBeKmDT"/>
                    <div>
                        <p class="font-bold text-on-surface">Dr. Elena Thorne</p>
                        <p class="text-xs text-on-surface-variant">Pathology Department</p>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-sm py-2 border-b border-surface-variant/30">
                        <span class="text-on-surface-variant">Engine</span>
                        <span class="text-on-surface">F-Chain v4.2</span>
                    </div>
                    <div class="flex justify-between items-center text-sm py-2 border-b border-surface-variant/30">
                        <span class="text-on-surface-variant">Date</span>
                        <span class="text-on-surface"><?= date('M d, Y') ?></span>
                    </div>
                </div>
            </div>

            <div class="bg-inverse-surface text-surface rounded-xl p-6 relative overflow-hidden">
                <h3 class="font-bold mb-4">Symptom Matching</h3>
                <div class="space-y-3">
                    <?php
                    $gejala_all = get_all_gejala($pdo);
                    foreach ($gejala_all as $g):
                        if (in_array($g['id'], $selected_gejala)):
                    ?>
                    <div class="flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-primary"></span>
                        <span class="text-sm"><?= $g['nama'] ?></span>
                    </div>
                    <?php
                        endif;
                    endforeach;
                    ?>
                </div>
                <div class="absolute top-0 right-0 w-full h-full opacity-10 pointer-events-none bg-gradient-to-br from-primary to-transparent"></div>
            </div>

            <a href="konsultasi.php" class="w-full bg-primary text-on-primary py-4 rounded-xl font-bold flex items-center justify-center gap-2 hover:bg-primary-dim transition-colors shadow-lg">
                <span class="material-symbols-outlined">restart_alt</span>
                Diagnosa Ulang
            </a>
        </aside>
    </div>
    <?php else: ?>
    <div class="bg-surface-container-low p-12 rounded-3xl text-center">
        <span class="material-symbols-outlined text-6xl text-on-surface-variant/20 mb-6">search_off</span>
        <h2 class="text-3xl font-bold text-on-surface mb-4">Diagnosis Tidak Ditemukan</h2>
        <p class="text-on-surface-variant max-w-md mx-auto mb-8">
            Maaf, kombinasi gejala yang Anda berikan tidak cocok dengan aturan penyakit yang ada di basis pengetahuan kami. Mohon konsultasikan dengan dokter hewan untuk pemeriksaan lebih lanjut.
        </p>
        <a href="konsultasi.php" class="inline-flex items-center gap-2 px-8 py-4 bg-primary text-on-primary rounded-xl font-bold hover:bg-primary-dim transition-all">
            <span class="material-symbols-outlined">arrow_back</span> Kembali ke Konsultasi
        </a>
    </div>
    <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>
