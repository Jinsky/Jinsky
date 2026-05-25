<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title><?= isset($page_title) ? $page_title . ' | Clinical Vitality' : 'Clinical Vitality | Avian Research & Diagnosis' ?></title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Google Fonts: Noto Serif & Manrope -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif:ital,wght@0,400;0,700;1,400;1,700&family=Manrope:wght@200..800&display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "tertiary-fixed-dim": "#d3bbff",
                        "primary-fixed": "#b6ecf6",
                        "on-tertiary-fixed-variant": "#552f98",
                        "primary-fixed-dim": "#9acfda",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#00504a",
                        "surface-container-highest": "#dfe3e7",
                        "surface-container-high": "#e4e9ed",
                        "surface-container-low": "#f0f4f8",
                        "outline-variant": "#c1c7d1",
                        "tertiary-fixed": "#ebddff",
                        "on-secondary-fixed": "#00201d",
                        "on-surface-variant": "#414750",
                        "on-secondary-container": "#1c7069",
                        "on-primary-fixed-variant": "#134e57",
                        "on-primary-fixed": "#001f24",
                        "outline": "#717881",
                        "secondary-container": "#a4f1e7",
                        "on-error": "#ffffff",
                        "on-surface": "#171c1f",
                        "surface-container-lowest": "#ffffff",
                        "on-primary-container": "#a3d9e3",
                        "surface-variant": "#dfe3e7",
                        "inverse-on-surface": "#edf1f5",
                        "primary": "#094851",
                        "secondary": "#126a63",
                        "on-tertiary-fixed": "#250059",
                        "tertiary": "#4f2992",
                        "inverse-primary": "#9acfda",
                        "surface-dim": "#d6dade",
                        "surface-bright": "#f6fafe",
                        "secondary-fixed-dim": "#88d4cb",
                        "inverse-surface": "#2c3134",
                        "primary-container": "#2a6069",
                        "on-background": "#171c1f",
                        "on-tertiary-container": "#dac6ff",
                        "tertiary-container": "#6743ab",
                        "surface-tint": "#30666f",
                        "on-error-container": "#93000a",
                        "surface": "#f6fafe",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "background": "#f6fafe",
                        "on-secondary": "#ffffff",
                        "surface-container": "#eaeef2",
                        "secondary-fixed": "#a4f1e7",
                        "on-primary": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "fontFamily": {
                        "headline": ["Noto Serif"],
                        "body": ["Manrope"],
                        "label": ["Manrope"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Manrope', sans-serif; }
        h1, h2, h3, .font-headline { font-family: 'Noto Serif', serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen flex flex-col">
    <?php if (!isset($hide_top_nav) || !$hide_top_nav): ?>
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-primary backdrop-blur-xl shadow-lg transition-all duration-300 ease-in-out">
        <div class="flex justify-between items-center max-w-7xl mx-auto px-8 h-20">
            <div class="text-2xl font-headline italic font-bold text-on-primary">
                <a href="index.php">Clinical Vitality</a>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a class="font-headline text-lg tracking-tight <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-on-primary border-b-2 border-on-primary font-bold pb-1' : 'text-on-primary/70 hover:text-on-primary transition-colors' ?>" href="index.php">Beranda</a>
                <a class="font-headline text-lg tracking-tight <?= basename($_SERVER['PHP_SELF']) == 'konsultasi.php' ? 'text-on-primary border-b-2 border-on-primary font-bold pb-1' : 'text-on-primary/70 hover:text-on-primary transition-colors' ?>" href="konsultasi.php">Konsultasi</a>
                <a class="font-headline text-lg tracking-tight <?= basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'text-on-primary border-b-2 border-on-primary font-bold pb-1' : 'text-on-primary/70 hover:text-on-primary transition-colors' ?>" href="riwayat.php">Riwayat</a>
                <a class="font-headline text-lg tracking-tight <?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'text-on-primary border-b-2 border-on-primary font-bold pb-1' : 'text-on-primary/70 hover:text-on-primary transition-colors' ?>" href="katalog.php">Katalog Penyakit</a>
                <a class="font-headline text-lg tracking-tight <?= basename($_SERVER['PHP_SELF']) == 'tentang.php' ? 'text-on-primary border-b-2 border-on-primary font-bold pb-1' : 'text-on-primary/70 hover:text-on-primary transition-colors' ?>" href="tentang.php">Tentang</a>
            </div>
            <div class="flex items-center gap-4">
            </div>
        </div>
    </nav>
    <?php endif; ?>
