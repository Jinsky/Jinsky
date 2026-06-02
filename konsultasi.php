<?php
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pemilik = $_POST['nama_pemilik'] ?? '';
    $selected_gejala = $_POST['gejala'] ?? [];

    if (empty($selected_gejala)) {
        $error = "Silakan pilih setidaknya satu gejala.";
    } else {
        $results = get_diagnosa($pdo, $selected_gejala);

        if (!empty($results)) {
            $primary_disease = $results[0];
            // If multiple diseases found, store all as comma-separated
            $disease_ids = array_column($results, 'id_penyakit');
            save_diagnosa($pdo, $nama_pemilik, implode(',', $disease_ids), $selected_gejala, $primary_disease['confidence']);

            // Redirect to results with the last inserted ID if possible
            if ($pdo) {
                $last_id = $pdo->lastInsertId();
                header("Location: hasil.php?id=$last_id");
            } else {
                // For mock mode, just pass parameters
                header("Location: hasil.php?mock=1&id_penyakit=" . $primary_disease['id_penyakit'] . "&confidence=" . $primary_disease['confidence'] . "&gejala=" . implode(',', $selected_gejala));
            }
            exit;
        } else {
            $error = "Sistem tidak dapat mengidentifikasi penyakit berdasarkan gejala tersebut.";
        }
    }
}

$page_title = "Konsultasi Diagnosa";
include 'includes/header.php';

$gejala_list = get_all_gejala($pdo);
?>

<main class="pt-24 min-h-screen bg-surface-container-lowest">
    <div class="max-w-4xl mx-auto px-8 pb-20">
        <div class="text-center mb-16">
            <h1 class="text-5xl font-bold text-primary font-headline mb-4">Konsultasi Diagnosa</h1>
            <p class="text-xl text-on-surface-variant font-body">Input kondisi merpati Anda untuk mendapatkan analisis klinis awal.</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="bg-red-50 text-red-600 p-6 rounded-[2rem] border border-red-100 mb-10 flex items-center gap-4">
                <span class="material-symbols-outlined">error</span>
                <p class="font-bold"><?= $error ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-12">
            <!-- Owner Info -->
            <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-primary/5 border border-outline-variant/30">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-primary-container text-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">person</span>
                    </div>
                    <h2 class="text-2xl font-bold text-primary font-headline">Data Pemilik</h2>
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-on-surface-variant font-label uppercase tracking-widest ml-4">Nama Pemilik</label>
                    <input type="text" name="nama_pemilik" required placeholder="Masukkan nama lengkap Anda" class="w-full px-8 py-4 bg-surface-container border-none rounded-2xl outline-none focus:ring-2 focus:ring-primary/20 transition-all font-body text-lg">
                </div>
            </div>

            <!-- Symptom Selection -->
            <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-primary/5 border border-outline-variant/30">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-2xl bg-secondary-container text-secondary flex items-center justify-center">
                        <span class="material-symbols-outlined">list_alt</span>
                    </div>
                    <h2 class="text-2xl font-bold text-primary font-headline">Pilih Gejala yang Teramati</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php foreach ($gejala_list as $g): ?>
                        <label class="group relative flex items-center p-6 rounded-2xl bg-surface-container hover:bg-primary/5 border-2 border-transparent hover:border-primary/20 transition-all cursor-pointer">
                            <div class="relative flex items-center justify-center w-6 h-6 mr-6">
                                <input type="checkbox" name="gejala[]" value="<?= $g['id_gejala'] ?>" class="peer appearance-none w-6 h-6 border-2 border-outline-variant rounded-md checked:bg-primary checked:border-primary transition-all">
                                <span class="material-symbols-outlined absolute text-white text-sm scale-0 peer-checked:scale-100 transition-transform">check</span>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-xs font-mono font-bold text-secondary mb-1 opacity-60"><?= $g['id_gejala'] ?></span>
                                <span class="text-primary font-bold font-body group-hover:text-primary transition-colors"><?= $g['nama'] ?></span>
                            </div>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex items-center justify-center pt-8">
                <button type="submit" class="group px-12 py-5 rounded-full bg-primary text-white font-extrabold text-xl shadow-2xl shadow-primary/30 hover:scale-105 active:scale-95 transition-all flex items-center gap-4">
                    Proses Diagnosa
                    <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform">analytics</span>
                </button>
            </div>
        </form>
    </div>
</main>

<?php include 'includes/footer.php'; ?>
