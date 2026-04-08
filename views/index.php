<?php
$pageTitle = $lang === 'sk' ? 'Dokumentácia' : 'Documentation';
$pageDescription = $lang === 'sk'
    ? 'Používateľské príručky pre platformu Selzee.'
    : 'User guides for the Selzee e-commerce chatbot platform.';

ob_start();
?>
<div class="max-w-3xl mx-auto px-4 py-12 sm:py-16">
    <h1 class="text-2xl font-semibold sm:text-3xl mb-6">
        <?= $lang === 'sk' ? 'Dokumentácia' : 'Documentation' ?>
    </h1>

    <div class="flex flex-col gap-3">
        <?php foreach ($pageList as $p): ?>
            <a href="/<?= $lang === 'sk' ? 'sk/' : '' ?><?= $p['slug'] ?>"
               class="border border-base-200 rounded-xl p-5 transition-colors hover:bg-base-200">
                <h2 class="font-medium"><?= htmlspecialchars($p['title']) ?></h2>
                <?php if ($p['description']): ?>
                    <p class="text-base-content/60 mt-1 text-sm"><?= htmlspecialchars($p['description']) ?></p>
                <?php endif; ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
