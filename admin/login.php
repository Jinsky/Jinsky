<?php
session_start();
require_once '../includes/db.php';

// Logout logic
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit;
}

$error = '';

// HAPUS atau KOMENTAR bagian ini untuk sementara
// if (isset($_SESSION['id_admin'])) {
//     header('Location: index.php');
//     exit;
// }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password harus diisi.';
    } else {
        if (!$pdo) {
            $error = 'Koneksi database gagal. Silahkan coba lagi nanti.';
        } else {
            try {
                $stmt = $pdo->prepare("SELECT id_admin, username, password FROM admin WHERE username = ?");
                $stmt->execute([$username]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($admin && password_verify($password, $admin['password'])) {
                    $_SESSION['id_admin'] = $admin['id_admin'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['login_time'] = time();
                    
                    header('Location: index.php');
                    exit;
                } else {
                    $error = 'Username atau password salah.';
                }
            } catch (PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                $error = 'Terjadi kesalahan sistem. Silahkan coba lagi.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Klinik Merpati</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Manrope:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }
        h1 {
            font-family: 'Noto Serif', serif;
        }
    </style>
</head>

<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-cyan-900">Klinik Merpati</h1>
            <p class="text-slate-500 mt-2">Admin Control Panel</p>
        </div>

        <?php if ($error): ?>
            <div class="bg-red-50 text-red-600 p-4 rounded-xl mb-6 text-sm font-medium border border-red-100">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Username</label>
                <input type="text" name="username" required autocomplete="username"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-600 focus:border-cyan-600 outline-none transition-all">
            </div>
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                <input type="password" name="password" required autocomplete="current-password"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-600 focus:border-cyan-600 outline-none transition-all">
            </div>
            <button type="submit" class="w-full bg-cyan-900 text-white py-4 rounded-xl font-bold hover:bg-cyan-800 transition-colors shadow-lg">
                Masuk ke Panel
            </button>
        </form>
        <div class="mt-8 text-center">
            <a href="../index.php" class="text-sm text-slate-400 hover:text-cyan-900 transition-colors">← Kembali ke Beranda</a>
        </div>
    </div>
</body>

</html>