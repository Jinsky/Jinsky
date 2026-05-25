<?php
require_once 'auth.php';
check_login();
require_once '../includes/functions.php';

$message = '';
$error = '';

if (isset($_POST['add_rule'])) {
    if ($pdo) {
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO aturan (id, id_penyakit) VALUES (?, ?)");
            $stmt->execute([$_POST['id'], $_POST['id_penyakit']]);
            $pdo->commit();
            $message = "Aturan berhasil dibuat.";
        } catch (Exception $e) { $pdo->rollBack(); $error = "Gagal: " . $e->getMessage(); }
    }
}

if (isset($_POST['add_detail'])) {
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("INSERT INTO aturan_detail (id_aturan, id_gejala, bobot) VALUES (?, ?, ?)");
            $stmt->execute([$_POST['id_aturan'], $_POST['id_gejala'], $_POST['bobot']]);
            $message = "Gejala ditambahkan ke aturan.";
        } catch (Exception $e) { $error = "Gagal: " . $e->getMessage(); }
    }
}

if (isset($_POST['delete_detail'])) {
    if ($pdo) {
        $stmt = $pdo->prepare("DELETE FROM aturan_detail WHERE id_aturan = ? AND id_gejala = ?");
        $stmt->execute([$_POST['id_aturan'], $_POST['id_gejala']]);
        $message = "Gejala dihapus dari aturan.";
    }
}

if ($pdo) {
    $stmt = $pdo->query("
        SELECT a.id, p.nama as penyakit, COUNT(ad.id_gejala) as total_gejala
        FROM aturan a
        LEFT JOIN penyakit p ON a.id_penyakit = p.id
        LEFT JOIN aturan_detail ad ON a.id = ad.id_aturan
        GROUP BY a.id
    ");
    $aturan_list = $stmt->fetchAll();

    $gejala_all = get_all_gejala($pdo);
    $penyakit_all = get_all_penyakit($pdo);
} else {
    $aturan_list = [];
    $gejala_all = [];
    $penyakit_all = [];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Aturan | Admin Clinical Vitality</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet">
</head>
<body class="bg-slate-50 min-h-screen flex">
    <aside class="w-64 bg-cyan-950 text-white flex flex-col">
        <div class="p-6 text-xl font-bold italic border-b border-white/10">Admin Panel</div>
        <nav class="flex-1 p-4 space-y-2">
            <a href="index.php" class="block p-3 rounded hover:bg-white/10 transition">Dashboard</a>
            <a href="gejala.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Gejala</a>
            <a href="penyakit.php" class="block p-3 rounded hover:bg-white/10 transition">Kelola Penyakit</a>
            <a href="aturan.php" class="block p-3 rounded bg-cyan-800 transition">Kelola Aturan</a>
        </nav>
    </aside>

    <main class="flex-1 p-10 overflow-auto">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h1 class="text-4xl font-bold text-slate-800">Kelola Aturan</h1>
                <p class="text-slate-500 mt-2">Relasi antara Penyakit, Gejala, dan Bobot Persentase.</p>
            </div>
            <button onclick="document.getElementById('addRuleModal').classList.remove('hidden')" class="bg-cyan-900 text-white px-6 py-3 rounded-xl font-bold shadow-lg">
                + Aturan Baru
            </button>
        </div>

        <?php if($message): ?><div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6"><?= $message ?></div><?php endif; ?>
        <?php if($error): ?><div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6"><?= $error ?></div><?php endif; ?>

        <div class="grid grid-cols-1 gap-8">
            <?php foreach($aturan_list as $a): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-8">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800"><?= $a['penyakit'] ?></h3>
                        <p class="text-sm font-mono text-cyan-700 uppercase tracking-widest mt-1">ID Aturan: <?= $a['id'] ?></p>
                    </div>
                    <button onclick="openDetailModal('<?= $a['id'] ?>')" class="bg-slate-100 text-slate-700 px-4 py-2 rounded-lg text-sm font-bold hover:bg-slate-200 transition">
                        + Tambah Gejala
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="p-4 font-bold text-slate-600">Kode</th>
                                <th class="p-4 font-bold text-slate-600">Gejala</th>
                                <th class="p-4 font-bold text-slate-600 text-center">Bobot (%)</th>
                                <th class="p-4 font-bold text-slate-600 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php
                            if ($pdo) {
                                $stmt = $pdo->prepare("
                                    SELECT ad.*, g.nama
                                    FROM aturan_detail ad
                                    JOIN gejala g ON ad.id_gejala = g.id
                                    WHERE ad.id_aturan = ?
                                ");
                                $stmt->execute([$a['id']]);
                                $details = $stmt->fetchAll();
                                foreach($details as $d):
                                ?>
                                <tr>
                                    <td class="p-4 font-mono font-bold text-cyan-600"><?= $d['id_gejala'] ?></td>
                                    <td class="p-4 text-slate-700"><?= $d['nama'] ?></td>
                                    <td class="p-4 text-center font-bold"><?= $d['bobot'] ?>%</td>
                                    <td class="p-4 text-right">
                                        <form method="POST" class="inline">
                                            <input type="hidden" name="id_aturan" value="<?= $a['id'] ?>">
                                            <input type="hidden" name="id_gejala" value="<?= $d['id_gejala'] ?>">
                                            <button name="delete_detail" class="text-red-400 hover:text-red-600 material-symbols-outlined text-sm">close</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach;
                            } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <div id="addRuleModal" class="fixed inset-0 bg-slate-900/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6">Buat Aturan Baru</h2>
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-bold mb-1">ID Aturan (Contoh: R31)</label>
                    <input type="text" name="id" required class="w-full border p-3 rounded-xl">
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Pilih Penyakit</label>
                    <select name="id_penyakit" class="w-full border p-3 rounded-xl">
                        <?php foreach($penyakit_all as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= $p['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('addRuleModal').classList.add('hidden')" class="flex-1 py-3 border rounded-xl">Batal</button>
                    <button type="submit" name="add_rule" class="flex-1 py-3 bg-cyan-900 text-white rounded-xl font-bold">Buat</button>
                </div>
            </form>
        </div>
    </div>

    <div id="addDetailModal" class="fixed inset-0 bg-slate-900/50 hidden flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-2xl p-8 max-w-md w-full">
            <h2 class="text-2xl font-bold mb-6">Tambah Gejala ke Aturan</h2>
            <form method="POST" class="space-y-4">
                <input type="hidden" name="id_aturan" id="modal_id_aturan">
                <div>
                    <label class="block text-sm font-bold mb-1">Pilih Gejala</label>
                    <select name="id_gejala" class="w-full border p-3 rounded-xl">
                        <?php foreach($gejala_all as $g): ?>
                        <option value="<?= $g['id'] ?>"><?= $g['id'] ?> - <?= $g['nama'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">Bobot Persentase (1-100)</label>
                    <input type="number" name="bobot" min="1" max="100" required class="w-full border p-3 rounded-xl">
                </div>
                <div class="flex gap-4 pt-4">
                    <button type="button" onclick="document.getElementById('addDetailModal').classList.add('hidden')" class="flex-1 py-3 border rounded-xl">Batal</button>
                    <button type="submit" name="add_detail" class="flex-1 py-3 bg-cyan-900 text-white rounded-xl font-bold">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openDetailModal(idAturan) {
            document.getElementById('modal_id_aturan').value = idAturan;
            document.getElementById('addDetailModal').classList.remove('hidden');
        }
    </script>
</body>
</html>
