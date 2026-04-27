<?php
require_once 'auth.php';
check_login();
require_once '../includes/functions.php';

$message = '';
$error = '';

if (isset($_POST['add'])) {
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO penyakit (id, nama, deskripsi, solusi, pencegahan) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$_POST['id'], $_POST['nama'], $_POST['deskripsi'], $_POST['solusi'], $_POST['pencegahan']]);
            $message = "Penyakit berhasil ditambahkan.";
        } catch (Exception $e) { $error = "Gagal: " . $e->getMessage(); }
    }
}

if (isset($_POST['delete'])) {
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM penyakit WHERE id = ?");
        $stmt->execute([$_POST['id']]);
        $message = "Penyakit berhasil dihapus.";
    }
}

$penyakit_list = get_all_penyakit($pdo);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Penyakit | Admin Clinical Vitality</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex">
    <aside class="w-64 bg-cyan-950 text-white flex flex-col">
        <div class="p-6 text-xl font-bold italic border-b border-white/10">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="block p-3 rounded hover:bg-white/10 transition">Dashboard</a>
            <a href="gejala.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Gejala</a>
            <a href="penyakit.php" class="block p-3 rounded bg-cyan-800 transition">Kelola Penyakit</a>
            <a href="aturan.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Aturan</a>
        </nav>
    </aside>

    <main class="flex-1 p-10 overflow-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">Kelola Penyakit</h1>
                <p class="text-slate-500 mt-2">Daftar penyakit merpati dalam basis pengetahuan.</p>
            </div>
            <button onclick="document.getElementById('addModal').classList.remove('hidden')" class="bg-cyan-900 text-white px-6 py-3 rounded-xl font-bold shadow-lg">
                + Tambah Penyakit
            </button>
        </div>

        <?php if($message): ?><div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6"><?= $message ?></div><?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="p-6 font-bold text-slate-600">ID</th>
                        <th class="p-6 font-bold text-slate-600">Nama Penyakit</th>
                        <th class="p-6 font-bold text-slate-600">Deskripsi</th>
                        <th class="p-6 font-bold text-slate-600 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach($penyakit_list as $p): ?>
                    <tr>
                        <td class="p-6 font-mono text-cyan-700 font-bold"><?= $p['id'] ?></td>
                        <td class="p-6 font-bold text-slate-800"><?= $p['nama'] ?></td>
                        <td class="p-6 text-slate-500 text-sm max-w-xs truncate"><?= $p['deskripsi'] ?></td>
                        <td class="p-6 text-right">
                            <form method="POST" onsubmit="return confirm('Hapus penyakit ini?')">
                                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                <button name="delete" class="text-red-400 hover:text-red-600 transition material-symbols-outlined">delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>

    <div id="addModal" class="fixed inset-0 bg-slate-900/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-2xl w-full max-h-[90vh] overflow-auto">
            <h2 class="text-2xl font-bold mb-6">Tambah Penyakit Baru</h2>
            <form method="POST" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold mb-1">ID (Contoh: P11)</label>
                        <input type="text" name="id" required class="w-full border p-3 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-bold mb-1">Nama Penyakit</label>
                        <input type="text" name="nama" required class="w-full border p-3 rounded-xl">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Deskripsi</label>
                    <textarea name="deskripsi" required class="w-full border p-3 rounded-xl h-24"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Solusi / Penanganan</label>
                    <textarea name="solusi" required class="w-full border p-3 rounded-xl h-24"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Langkah Pencegahan</label>
                    <textarea name="pencegahan" required class="w-full border p-3 rounded-xl h-24"></textarea>
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
