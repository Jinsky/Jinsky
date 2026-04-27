<?php
require_once 'auth.php';
check_login();
require_once '../includes/functions.php';

$total_gejala = count(get_all_gejala($pdo));
$total_penyakit = count(get_all_penyakit($pdo));
if ($pdo) {
    $total_riwayat = $pdo->query("SELECT COUNT(*) FROM diagnosa")->fetchColumn();
    $total_aturan = $pdo->query("SELECT COUNT(*) FROM aturan")->fetchColumn();
} else {
    $total_riwayat = 0;
    $total_aturan = 0;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard | Clinical Vitality</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex">
    <aside class="w-64 bg-cyan-950 text-white flex flex-col">
        <div class="p-6 text-xl font-bold italic border-b border-white/10">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="block p-3 rounded bg-cyan-800 transition">Dashboard</a>
            <a href="gejala.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Gejala</a>
            <a href="penyakit.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Penyakit</a>
            <a href="aturan.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Aturan</a>
        </nav>
        <div class="p-6 border-t border-white/10">
            <a href="login.php?logout=1" class="text-sm text-slate-400">Logout</a>
        </div>
    </aside>

    <main class="flex-1 p-10">
        <h1 class="text-4xl font-bold text-slate-800 mb-2">Selamat Datang, <?= $_SESSION['admin_username'] ?></h1>
        <p class="text-slate-500 mb-10">Ringkasan data sistem pakar Clinical Vitality.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="w-12 h-12 bg-cyan-100 text-cyan-900 rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">vital_signs</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Gejala</p>
                <p class="text-4xl font-bold text-slate-800"><?= $total_gejala ?></p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="w-12 h-12 bg-purple-100 text-purple-900 rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">microbiology</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Penyakit</p>
                <p class="text-4xl font-bold text-slate-800"><?= $total_penyakit ?></p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="w-12 h-12 bg-amber-100 text-amber-900 rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">rule</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Aturan</p>
                <p class="text-4xl font-bold text-slate-800"><?= $total_aturan ?></p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
                <div class="w-12 h-12 bg-emerald-100 text-emerald-900 rounded-xl flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined">history</span>
                </div>
                <p class="text-sm font-bold text-slate-500 uppercase tracking-widest">Diagnosa</p>
                <p class="text-4xl font-bold text-slate-800"><?= $total_riwayat ?></p>
            </div>
        </div>

        <div class="mt-12 bg-cyan-900 text-white p-10 rounded-[2.5rem] relative overflow-hidden">
            <div class="relative z-10">
                <h2 class="text-3xl font-bold mb-4">Butuh Bantuan?</h2>
                <p class="max-w-xl opacity-80 mb-8 text-lg">Gunakan panel navigasi di samping untuk mengelola basis pengetahuan. Anda dapat menambah gejala baru, penyakit, atau mengatur ulang bobot aturan diagnosa.</p>
                <a href="../index.php" class="bg-white text-cyan-950 px-8 py-3 rounded-xl font-bold hover:bg-slate-100 transition inline-block">Lihat Situs Depan</a>
            </div>
            <span class="material-symbols-outlined absolute -right-10 -bottom-10 text-[15rem] opacity-10">clinical_notes</span>
        </div>
    </main>
</body>
</html>
