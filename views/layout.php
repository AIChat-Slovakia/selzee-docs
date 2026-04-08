<!DOCTYPE html>
<html lang="<?= $lang === 'sk' ? 'sk-SK' : 'en' ?>" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selzee | <?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? '') ?>">
    <link rel="icon" href="https://selzee.com/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
    </style>
</head>
<body class="bg-base-100 text-base-content min-h-screen">
    <header class="border-b border-base-200">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between">
            <a href="/<?= $lang === 'sk' ? 'sk' : '' ?>" class="font-semibold text-lg">Selzee Docs</a>
            <div class="flex gap-1">
                <a href="<?= $lang === 'sk' && isset($slug) ? "/{$slug}" : '/' ?>"
                   class="btn btn-ghost btn-xs <?= $lang === 'en' ? 'btn-active' : '' ?>">EN</a>
                <a href="<?= isset($slug) ? "/sk/{$slug}" : '/sk' ?>"
                   class="btn btn-ghost btn-xs <?= $lang === 'sk' ? 'btn-active' : '' ?>">SK</a>
            </div>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>
</body>
</html>
