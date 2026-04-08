<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>The Clinical Naturalist | Pigeon Disease Expert System</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <!-- Google Fonts: Manrope & Public Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;family=Public+Sans:ital,wght@0,100..900;1,100..900&amp;display=swap" rel="stylesheet"/>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#d2eca2",
                        "tertiary": "#516170",
                        "surface": "#f9f9f9",
                        "tertiary-fixed": "#dcedff",
                        "error-container": "#fe8b70",
                        "secondary-dim": "#0a5787",
                        "error": "#9e422c",
                        "background": "#f9f9f9",
                        "outline-variant": "#adb3b4",
                        "surface-dim": "#d4dbdd",
                        "secondary-container": "#cee5ff",
                        "on-primary-fixed": "#32450d",
                        "on-error": "#fff7f6",
                        "surface-container-lowest": "#ffffff",
                        "on-background": "#2d3435",
                        "primary-dim": "#44591f",
                        "on-secondary-fixed": "#00436a",
                        "on-secondary-fixed-variant": "#1b6090",
                        "tertiary-fixed-dim": "#cedff1",
                        "surface-container-low": "#f2f4f4",
                        "inverse-surface": "#0c0f0f",
                        "tertiary-container": "#dcedff",
                        "on-surface": "#2d3435",
                        "on-secondary-container": "#065685",
                        "secondary-fixed": "#cee5ff",
                        "on-error-container": "#742410",
                        "inverse-on-surface": "#9c9d9d",
                        "on-tertiary-fixed": "#374655",
                        "on-primary-container": "#43581f",
                        "on-surface-variant": "#5a6061",
                        "inverse-primary": "#e0fbaf",
                        "surface-variant": "#dde4e5",
                        "surface-tint": "#50652a",
                        "surface-container-high": "#e4e9ea",
                        "on-primary-fixed-variant": "#4d6227",
                        "on-tertiary-fixed-variant": "#536372",
                        "primary": "#50652a",
                        "on-secondary": "#f6f9ff",
                        "surface-bright": "#f9f9f9",
                        "tertiary-dim": "#455564",
                        "secondary": "#216394",
                        "on-tertiary": "#f6f9ff",
                        "primary-container": "#d2eca2",
                        "on-primary": "#ecffc7",
                        "primary-fixed-dim": "#c4de95",
                        "error-dim": "#5c1202",
                        "outline": "#757c7d",
                        "secondary-fixed-dim": "#b2d8ff",
                        "on-tertiary-container": "#495867",
                        "surface-container-highest": "#dde4e5",
                        "surface-container": "#ebeeef"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "fontFamily": {
                        "headline": ["Manrope"],
                        "body": ["Public Sans"],
                        "label": ["Public Sans"]
                    }
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .tonal-transition-bg {
            background: linear-gradient(180deg, rgba(249,249,249,1) 0%, rgba(242,244,244,1) 100%);
        }
        .custom-checkbox:checked {
            background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        }
    </style>
</head>
<body class="bg-background text-on-background font-body selection:bg-primary-fixed selection:text-on-primary-fixed min-h-screen flex flex-col">
    <!-- Top Navigation Bar -->
    <nav class="fixed top-0 w-full z-50 bg-[#f9f9f9]/80 backdrop-blur-xl shadow-[0_12px_32px_rgba(80,101,42,0.08)]">
        <div class="flex justify-between items-center w-full px-8 py-4 max-w-screen-2xl mx-auto">
            <div class="text-xl font-black text-primary uppercase tracking-tighter font-headline">
                <a href="index.php">The Clinical Naturalist</a>
            </div>
            <div class="hidden md:flex gap-8 items-center">
                <a class="font-headline font-bold <?= basename($_SERVER['PHP_SELF']) == 'konsultasi.php' ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant/70 hover:text-primary transition-all duration-300' ?>" href="konsultasi.php">Consultation</a>
                <a class="font-headline font-bold <?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant/70 hover:text-primary transition-all duration-300' ?>" href="katalog.php">Disease Catalog</a>
                <a class="font-headline font-bold <?= basename($_SERVER['PHP_SELF']) == 'riwayat.php' ? 'text-primary border-b-2 border-primary pb-1' : 'text-on-surface-variant/70 hover:text-primary transition-all duration-300' ?>" href="riwayat.php">History</a>
                <a class="font-headline font-bold text-on-surface-variant/70 hover:text-primary transition-all duration-300" href="#">About</a>
            </div>
            <div class="flex items-center gap-4">
                <a href="konsultasi.php" class="px-6 py-2 bg-primary text-on-primary font-headline font-bold rounded-lg hover:bg-primary-dim transition-colors active:scale-95 duration-150">
                    Emergency Check
                </a>
            </div>
        </div>
    </nav>
