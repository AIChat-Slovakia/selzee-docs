<?php
$pageTitle = $page['title'] ?? 'Documentation';
$pageDescription = $page['description'] ?? '';

ob_start();
?>
<div class="max-w-5xl mx-auto px-4 py-12 sm:py-16">
    <div class="flex gap-10">
        <!-- Sidebar -->
        <aside class="hidden lg:block w-56 shrink-0">
            <div class="sticky top-8">
                <nav class="flex flex-col gap-0.5">
                    <?php foreach ($sidebar as $nav): ?>
                        <a href="/<?= $lang === 'sk' ? 'sk/' : '' ?><?= $nav['slug'] ?>"
                           class="rounded-lg px-3 py-1.5 text-sm transition-colors hover:bg-base-200 <?= $nav['slug'] === $slug ? 'bg-base-200 font-medium' : 'text-base-content/70' ?>">
                            <?= htmlspecialchars($nav['title']) ?>
                        </a>
                    <?php endforeach; ?>
                </nav>
            </div>
        </aside>

        <!-- Content -->
        <article class="flex-1 min-w-0">
            <!-- Mobile back -->
            <div class="mb-6 lg:hidden">
                <a href="/<?= $lang === 'sk' ? 'sk' : '' ?>" class="btn btn-ghost btn-xs gap-1">
                    ← <?= $lang === 'sk' ? 'Späť' : 'Back' ?>
                </a>
            </div>

            <h1 class="text-2xl font-semibold sm:text-3xl mb-6"><?= htmlspecialchars($page['title']) ?></h1>

            <div class="space-y-4 text-base-content/80 leading-relaxed">
                <?php
                $skipKeys = ['title', 'description'];
                foreach ($page as $key => $value):
                    if (in_array($key, $skipKeys, true)) continue;

                    $rendered = md($value);
                    $isShort = mb_strlen($value) <= 40;
                    $hasMarkdown = str_contains($value, '**') || str_contains($value, '—') || str_contains($value, '.');

                    if ($isShort && !$hasMarkdown):
                ?>
                    <h2 class="text-lg font-semibold text-base-content mt-8 first:mt-0"><?= $rendered ?></h2>
                <?php else: ?>
                    <p><?= $rendered ?></p>
                <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </article>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
