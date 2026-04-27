<?php
require_once 'auth.php';
check_login();
require_once '../includes/functions.php';

$message = '';
$error = '';

if (isset($_POST['add'])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO gejala (id, nama) VALUES (?, ?)");
            $stmt->execute([$id, $nama]);
            $message = "Gejala berhasil ditambahkan.";
        } catch (Exception $e) { $error = "Gagal: " . $e->getMessage(); }
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM gejala WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Gejala berhasil dihapus.";
    }
}

$gejala_list = get_all_gejala($pdo);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Gejala | Admin Klinik Merpati</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex">
    <aside class="w-64 bg-cyan-950 text-white flex flex-col">
        <div class="p-6 text-xl font-bold italic border-b border-white/10">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="block p-3 rounded hover:bg-white/10 transition">Dashboard</a>
            <a href="gejala.php" class="block p-3 rounded bg-cyan-800 transition">Kelola Gejala</a>
            <a href="penyakit.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Penyakit</a>
            <a href="aturan.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Aturan</a>
        </nav>
        <div class="p-6 border-t border-white/10">
            <a href="login.php?logout=1" class="text-sm text-slate-400">Logout</a>
        </div>
    </aside>

    <main class="flex-1 p-10">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">Kelola Gejala</h1>
                <p class="text-slate-500 mt-2">Daftar semua gejala klinis yang dapat dideteksi.</p>
            </div>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-cyan-900 text-white px-6 py-3 rounded-xl font-bold shadow-lg hover:bg-cyan-800 transition">
                + Tambah Gejala
            </button>
        </div>

        <?php if($message): ?><div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6"><?= $message ?></div><?php endif; ?>
        <?php if($error): ?><div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6"><?= $error ?></div><?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-6 font-bold text-slate-600">Kode</th>
                        <th class="p-6 font-bold text-slate-600">Nama Gejala</th>
                        <th class="p-6 font-bold text-slate-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($gejala_list as $g): ?>
                    <tr>
                        <td class="p-6 font-mono text-cyan-700 font-bold"><?= $g['id'] ?></td>
                        <td class="p-6 text-slate-700"><?= $g['nama'] ?></td>
                        <td class="p-6 text-right">
                            <form method="POST" onsubmit="return confirm('Hapus gejala ini?')">
                                <input type="hidden" name="id" value="<?= $g['id'] ?>">
                                <button name="delete" class="text-red-400 hover:text-red-600 transition material-symbols-outlined">delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="fixed inset-0 bg-slate-900/50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6">Tambah Gejala Baru</h2>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">ID (Contoh: G31)</label>
                    <input type="text" name="id" required class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-cyan-600">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Nama Gejala</label>
                    <input type="text" name="nama" required class="w-full border p-3 rounded-xl outline-none focus:ring-2 focus:ring-cyan-600">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('addModal').classList.add('hidden')" class="flex-1 py-3 border rounded-xl font-bold">Batal</button>
                    <button type="submit" name="add" class="flex-1 py-3 bg-cyan-900 text-white rounded-xl font-bold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
