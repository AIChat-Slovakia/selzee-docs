<?php
$pageTitle = $page['title'] ?? 'Documentation';
$pageDescription = $page['description'] ?? '';

ob_start();
?>
<style>
    .docs-layout {
        display: flex;
        gap: 0;
        min-height: calc(100vh - 57px);
    }

    /* ---- Sidebar ---- */
    .docs-sidebar {
        display: none;
        width: 260px;
        flex-shrink: 0;
        border-right: 1px solid var(--border);
        background: var(--bg);
        padding: 32px 16px 32px 24px;
        position: sticky;
        top: 57px;
        height: calc(100vh - 57px);
        overflow-y: auto;
    }
    @media (min-width: 1024px) {
        .docs-sidebar { display: block; }
    }

    .sidebar-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: var(--text-muted);
        padding: 0 12px;
        margin-bottom: 8px;
    }

    .sidebar-nav { display: flex; flex-direction: column; gap: 2px; }
    .sidebar-nav a {
        font-size: 13.5px;
        font-weight: 500;
        padding: 7px 12px;
        border-radius: 8px;
        color: var(--text-secondary);
        transition: all .15s ease;
        border-left: 2px solid transparent;
    }
    .sidebar-nav a:hover {
        color: var(--text);
        background: var(--bg-hover);
    }
    .sidebar-nav a.active {
        color: var(--text);
        font-weight: 600;
        background: var(--bg-active);
        border-left-color: var(--accent);
    }

    /* ---- Article ---- */
    .docs-content {
        flex: 1;
        min-width: 0;
        max-width: 740px;
        padding: 40px 24px 80px;
        margin: 0 auto;
    }

    .mobile-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-secondary);
        margin-bottom: 24px;
        padding: 6px 12px;
        border-radius: 8px;
        background: var(--bg-sidebar);
        transition: all .15s ease;
    }
    .mobile-back:hover { background: var(--bg-active); color: var(--text); }
    @media (min-width: 1024px) {
        .mobile-back { display: none; }
    }

    .docs-content h1 {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin-bottom: 8px;
        line-height: 1.2;
    }
    .docs-content .page-desc {
        color: var(--text-secondary);
        font-size: 15px;
        margin-bottom: 32px;
        padding-bottom: 24px;
        border-bottom: 1px solid var(--border);
    }

    .docs-content .doc-section h2 {
        font-size: 20px;
        font-weight: 700;
        letter-spacing: -0.015em;
        margin-top: 40px;
        margin-bottom: 12px;
        padding-top: 24px;
        border-top: 1px solid var(--border);
    }
    .docs-content .doc-section h2:first-child {
        margin-top: 0;
        padding-top: 0;
        border-top: none;
    }

    .docs-content .doc-section p {
        color: var(--text-secondary);
        font-size: 15px;
        line-height: 1.7;
        margin-bottom: 12px;
    }
    .docs-content .doc-section p strong {
        color: var(--text);
        font-weight: 600;
    }
    .docs-content .doc-section p code {
        font-size: 13px;
        background: var(--bg-sidebar);
        border: 1px solid var(--border);
        padding: 1px 6px;
        border-radius: 5px;
        font-family: 'SF Mono', 'Fira Code', monospace;
    }
</style>

<div class="docs-layout">
    <aside class="docs-sidebar">
        <div class="sidebar-label"><?= $lang === 'sk' ? 'Príručka' : 'Guide' ?></div>
        <nav class="sidebar-nav">
            <?php foreach ($sidebar as $nav): ?>
                <a href="/<?= $lang === 'sk' ? 'sk/' : '' ?><?= $nav['slug'] ?>"
                   class="<?= $nav['slug'] === $slug ? 'active' : '' ?>">
                    <?= htmlspecialchars($nav['title']) ?>
                </a>
            <?php endforeach; ?>
        </nav>
    </aside>

    <article class="docs-content">
        <a href="/<?= $lang === 'sk' ? 'sk' : '' ?>" class="mobile-back">
            ← <?= $lang === 'sk' ? 'Späť' : 'Back' ?>
        </a>

        <h1><?= htmlspecialchars($page['title']) ?></h1>

        <?php if (!empty($page['description'])): ?>
            <p class="page-desc"><?= htmlspecialchars($page['description']) ?></p>
        <?php endif; ?>

        <div class="doc-section">
            <?php
            $skipKeys = ['title', 'description'];
            foreach ($page as $key => $value):
                if (in_array($key, $skipKeys, true)) continue;

                $rendered = md($value);
                $isShort = mb_strlen($value) <= 40;
                $hasMarkdown = str_contains($value, '**') || str_contains($value, '—') || str_contains($value, '.');

                if ($isShort && !$hasMarkdown):
            ?>
                <h2><?= $rendered ?></h2>
            <?php else: ?>
                <p><?= $rendered ?></p>
            <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </article>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
