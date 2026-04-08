<!DOCTYPE html>
<html lang="<?= $lang === 'sk' ? 'sk-SK' : 'en' ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selzee | <?= htmlspecialchars($pageTitle) ?></title>
    <meta name="description" content="<?= htmlspecialchars($pageDescription ?? '') ?>">
    <link rel="icon" href="https://selzee.com/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #FAFAF9;
            --bg-card: #FFFFFF;
            --bg-sidebar: #F5F5F4;
            --bg-active: #E7E5E4;
            --bg-hover: #F0EFED;
            --text: #1C1917;
            --text-secondary: #78716C;
            --text-muted: #A8A29E;
            --border: #E7E5E4;
            --accent: #7C5CFC;
            --accent-light: #EDE9FE;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        a { color: inherit; text-decoration: none; }

        /* ---- Header ---- */
        .site-header {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(250,250,249,.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
        }
        .header-inner {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .site-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: -0.01em;
            color: var(--text);
        }
        .site-logo .logo-icon {
            width: 28px;
            height: 28px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 800;
            font-size: 13px;
        }
        .site-logo .logo-badge {
            font-size: 11px;
            font-weight: 600;
            color: var(--accent);
            background: var(--accent-light);
            padding: 2px 8px;
            border-radius: 6px;
            letter-spacing: 0.02em;
        }

        /* ---- Lang Switcher ---- */
        .lang-switch {
            display: flex;
            background: var(--bg-sidebar);
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
        }
        .lang-switch a {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 6px;
            color: var(--text-secondary);
            transition: all .15s ease;
        }
        .lang-switch a:hover { color: var(--text); background: var(--bg-hover); }
        .lang-switch a.active {
            background: var(--bg-card);
            color: var(--text);
            box-shadow: 0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
        }

        /* ---- Content ---- */
        .page-container {
            max-width: 1120px;
            margin: 0 auto;
            padding: 0 24px;
        }
    </style>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="/<?= $lang === 'sk' ? 'sk' : '' ?>" class="site-logo">
                <span class="logo-icon">S</span>
                Selzee
                <span class="logo-badge">Docs</span>
            </a>
            <div class="lang-switch">
                <a href="<?= $lang === 'sk' && isset($slug) ? "/{$slug}" : '/' ?>"
                   class="<?= $lang === 'en' ? 'active' : '' ?>">EN</a>
                <a href="<?= isset($slug) ? "/sk/{$slug}" : '/sk' ?>"
                   class="<?= $lang === 'sk' ? 'active' : '' ?>">SK</a>
            </div>
        </div>
    </header>

    <main>
        <?= $content ?>
    </main>
</body>
</html>
