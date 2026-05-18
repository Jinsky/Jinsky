<?php
// File: hash.php
// Gunakan file ini untuk menghasilkan hash password yang bisa digunakan dengan password_verify()

session_start();
$message = '';
$hashResult = '';
$passwordInput = '';

// Proses ketika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $passwordInput = $_POST['password'] ?? '';
    $algorithm = $_POST['algorithm'] ?? PASSWORD_DEFAULT;
    
    if (!empty($passwordInput)) {
        // Generate hash menggunakan password_hash()
        // PASSWORD_DEFAULT akan menggunakan algoritma terkuat yang tersedia (saat ini BCRYPT)
        $hashResult = password_hash($passwordInput, $algorithm);
        
        // Tampilkan informasi tentang algoritma yang digunakan
        $algoName = '';
        if ($algorithm === PASSWORD_DEFAULT) {
            $algoName = 'PASSWORD_DEFAULT (BCRYPT)';
        } elseif ($algorithm === PASSWORD_BCRYPT) {
            $algoName = 'BCRYPT';
        } elseif ($algorithm === PASSWORD_ARGON2I) {
            $algoName = 'ARGON2I';
        } elseif ($algorithm === PASSWORD_ARGON2ID) {
            $algoName = 'ARGON2ID';
        }
        
        $message = "<div class='success'>✅ Hash berhasil dibuat dengan algoritma: <strong>{$algoName}</strong></div>";
    } else {
        $message = "<div class='error'>❌ Harap masukkan password terlebih dahulu!</div>";
    }
}

// Generate hash untuk password default "admin123" sebagai contoh
$defaultPassword = 'admin123';
$defaultHash = password_hash($defaultPassword, PASSWORD_DEFAULT);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Hash Generator - Klinik Merpati</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:wght@700&family=Manrope:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Manrope', sans-serif; background: #f8fafc; }
        h1, h2, h3 { font-family: 'Noto Serif', serif; }
        .hash-result {
            word-break: break-all;
            font-family: monospace;
            font-size: 14px;
            background: #f1f5f9;
            padding: 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
        }
        .success {
            background: #dcfce7;
            color: #166534;
            padding: 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid #22c55e;
        }
        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid #ef4444;
        }
        .info {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.75rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body class="min-h-screen py-12">
    <div class="max-w-3xl mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-cyan-900">🔐 Password Hash Generator</h1>
            <p class="text-slate-500 mt-2">Untuk Login Admin Klinik Merpati</p>
        </div>

        <!-- Form Generate Hash -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8 mb-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4">Generate Hash Password Baru</h2>
            
            <?= $message ?>
            
            <form method="POST" class="space-y-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" value="<?= htmlspecialchars($passwordInput) ?>" required 
                           class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-600 outline-none transition-all">
                </div>
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Algoritma Hash</label>
                    <select name="algorithm" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-cyan-600 outline-none">
                        <option value="<?= PASSWORD_DEFAULT ?>">PASSWORD_DEFAULT (BCRYPT - Rekomendasi)</option>
                        <option value="<?= PASSWORD_BCRYPT ?>">BCRYPT</option>
                        <?php if (defined('PASSWORD_ARGON2I')): ?>
                        <option value="<?= PASSWORD_ARGON2I ?>">ARGON2I</option>
                        <?php endif; ?>
                        <?php if (defined('PASSWORD_ARGON2ID')): ?>
                        <option value="<?= PASSWORD_ARGON2ID ?>">ARGON2ID</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <button type="submit" class="w-full bg-cyan-900 text-white py-4 rounded-xl font-bold hover:bg-cyan-800 transition-colors shadow-lg">
                    🔄 Generate Hash
                </button>
            </form>
            
            <?php if ($hashResult): ?>
            <div class="mt-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">📋 Hasil Hash:</label>
                <div class="hash-result mb-3">
                    <?= htmlspecialchars($hashResult) ?>
                </div>
                <button onclick="copyToClipboard()" class="w-full bg-slate-600 text-white py-2 rounded-lg font-medium hover:bg-slate-700 transition-colors">
                    📋 Copy Hash ke Clipboard
                </button>
            </div>
            
            <!-- SQL Insert Suggestion -->
            <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                <h3 class="font-bold text-blue-800 mb-2">💡 SQL untuk insert/update admin:</h3>
                <pre class="text-xs bg-slate-800 text-green-300 p-3 rounded-lg overflow-x-auto"><code>-- Insert admin baru
INSERT INTO admin (username, password) VALUES ('nama_admin', '<?= addslashes($hashResult) ?>');

-- Update password admin existing
UPDATE admin SET password = '<?= addslashes($hashResult) ?>' WHERE username = 'admin';</code></pre>
            </div>
            <?php endif; ?>
        </div>

        <!-- Informasi dan Contoh -->
        <div class="bg-white rounded-2xl shadow-xl p-6 md:p-8">
            <h2 class="text-xl font-bold text-slate-800 mb-4">📖 Informasi Penting</h2>
            
            <div class="space-y-4">
                <div class="info">
                    <strong>🔍 Cara Verifikasi:</strong> Gunakan fungsi <code class="bg-slate-200 px-1 rounded">password_verify()</code> seperti pada kode login Anda.
                </div>
                
                <div class="info">
                    <strong>🔑 Contoh Password Default:</strong> "admin123"<br>
                    <strong class="mt-2 block">Hash untuk "admin123":</strong>
                    <code class="block mt-1 text-xs bg-slate-800 text-green-300 p-2 rounded overflow-x-auto"><?= htmlspecialchars($defaultHash) ?></code>
                </div>
                
                <div class="info">
                    <strong>⚙️ Cara Menggunakan:</strong>
                    <ol class="list-decimal list-inside mt-2 space-y-1 text-sm">
                        <li>Masukkan password yang ingin di-hash</li>
                        <li>Klik "Generate Hash"</li>
                        <li>Copy hash yang dihasilkan</li>
                        <li>Update kolom <code class="bg-slate-200 px-1 rounded">password</code> di tabel <code class="bg-slate-200 px-1 rounded">admin</code> dengan hash tersebut</li>
                        <li>Login menggunakan password asli akan berhasil karena <code class="bg-slate-200 px-1 rounded">password_verify()</code> akan mencocokkan</li>
                    </ol>
                </div>
                
                <div class="bg-amber-50 p-4 rounded-xl border border-amber-200">
                    <h3 class="font-bold text-amber-800 mb-2">⚠️ Catatan Penting:</h3>
                    <ul class="list-disc list-inside text-sm text-amber-700 space-y-1">
                        <li>Hash yang dihasilkan bersifat <strong>one-way</strong> (tidak bisa didekripsi kembali)</li>
                        <li>Setiap generate akan menghasilkan hash yang <strong>berbeda</strong> meskipun passwordnya sama (karena ada salt)</li>
                        <li>Gunakan hash yang baru saja Anda generate, bukan dari contoh di atas</li>
                        <li>Pastikan kolom <code class="bg-amber-100 px-1 rounded">password</code> di database cukup panjang (minimal 255 karakter)</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Link kembali -->
        <div class="text-center mt-8">
            <a href="login.php" class="text-sm text-slate-400 hover:text-cyan-900 transition-colors">← Kembali ke Halaman Login</a>
        </div>
    </div>

    <script>
        function copyToClipboard() {
            const hashText = document.querySelector('.hash-result').innerText;
            navigator.clipboard.writeText(hashText).then(() => {
                alert('✅ Hash berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('❌ Gagal menyalin hash');
            });
        }
        
        // Auto-submit jika ada parameter ?password=xxx di URL (opsional untuk debugging)
        const urlParams = new URLSearchParams(window.location.search);
        const autoPass = urlParams.get('password');
        if (autoPass && !<?= json_encode(!empty($hashResult)) ?>) {
            document.querySelector('input[name="password"]').value = autoPass;
            document.querySelector('form').submit();
        }
    </script>
</body>
</html>