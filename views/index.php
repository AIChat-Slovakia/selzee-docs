<?php
$pageTitle = $lang === 'sk' ? 'Dokumentácia' : 'Documentation';
$pageDescription = $lang === 'sk'
    ? 'Používateľské príručky pre platformu Selzee.'
    : 'User guides for the Selzee e-commerce chatbot platform.';

$icons = [
    'overview' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />',
    'conversations' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />',
    'data-sources' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />',
    'agent' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />',
    'analytics' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />',
];

ob_start();
?>
<style>
    .hero-section {
        padding: 56px 0 48px;
        text-align: center;
    }
    .hero-section h1 {
        font-size: 32px;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin-bottom: 8px;
    }
    .hero-section p {
        color: var(--text-secondary);
        font-size: 15px;
        max-width: 480px;
        margin: 0 auto;
    }

    .cards-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 12px;
        max-width: 720px;
        margin: 0 auto;
        padding-bottom: 80px;
    }
    @media (min-width: 640px) {
        .cards-grid { grid-template-columns: 1fr 1fr; }
    }

    .doc-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 20px;
        display: flex;
        gap: 14px;
        transition: all .2s ease;
        cursor: pointer;
    }
    .doc-card:hover {
        border-color: #D6D3D1;
        box-shadow: 0 4px 12px rgba(0,0,0,.04), 0 1px 3px rgba(0,0,0,.03);
        transform: translateY(-1px);
    }

    .doc-card .card-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: var(--accent-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .doc-card .card-icon svg {
        width: 20px;
        height: 20px;
        stroke: var(--accent);
        fill: none;
        stroke-width: 1.5;
    }
    .doc-card .card-body h2 {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 4px;
        letter-spacing: -0.01em;
    }
    .doc-card .card-body p {
        font-size: 13px;
        color: var(--text-secondary);
        line-height: 1.5;
    }
</style>

<div class="page-container">
    <div class="hero-section">
        <h1><?= $lang === 'sk' ? 'Dokumentácia' : 'Documentation' ?></h1>
        <p><?= $lang === 'sk'
            ? 'Používateľské príručky pre platformu Selzee.'
            : 'User guides for the Selzee e-commerce chatbot platform.' ?></p>
    </div>

    <div class="cards-grid">
        <?php foreach ($pageList as $p): ?>
            <a href="/<?= $lang === 'sk' ? 'sk/' : '' ?><?= $p['slug'] ?>" class="doc-card">
                <div class="card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><?= $icons[$p['slug']] ?? '' ?></svg>
                </div>
                <div class="card-body">
                    <h2><?= htmlspecialchars($p['title']) ?></h2>
                    <?php if ($p['description']): ?>
                        <p><?= htmlspecialchars($p['description']) ?></p>
                    <?php endif; ?>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
