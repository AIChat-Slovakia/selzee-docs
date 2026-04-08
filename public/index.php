<?php

$basePath = dirname(__DIR__);
$uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$uri = rtrim($uri, '/') ?: '/';

$pages = ['overview', 'conversations', 'data-sources', 'agent', 'analytics'];

// Parse route: /sk/agent, /agent, /sk, /
$lang = 'en';
$slug = null;

if (preg_match('#^/sk(?:/(.+))?$#', $uri, $m)) {
    $lang = 'sk';
    $slug = $m[1] ?? null;
} elseif ($uri !== '/') {
    $slug = ltrim($uri, '/');
}

// Load a page from JSON
function loadPage(string $basePath, string $slug, string $lang): ?array
{
    $path = "{$basePath}/documentation/{$lang}/{$slug}.json";
    if (!file_exists($path)) {
        return null;
    }

    return json_decode(file_get_contents($path), true);
}

// Convert markdown bold/code to HTML
function md(string $text): string
{
    $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    $text = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $text);
    $text = preg_replace('/`(.+?)`/', '<code class="bg-base-200 px-1 rounded text-sm">$1</code>', $text);
    $text = preg_replace('/&quot;(.+?)&quot;/', '&ldquo;$1&rdquo;', $text);

    return $text;
}

// Route
if ($slug === null) {
    // Index page
    $pageList = [];
    foreach ($pages as $p) {
        $data = loadPage($basePath, $p, $lang);
        if ($data) {
            $pageList[] = ['slug' => $p, 'title' => $data['title'], 'description' => $data['description'] ?? ''];
        }
    }
    require "{$basePath}/views/index.php";
} elseif (in_array($slug, $pages, true)) {
    // Show page
    $page = loadPage($basePath, $slug, $lang);
    if (!$page) {
        http_response_code(404);
        echo 'Page not found';
        exit;
    }
    $sidebar = [];
    foreach ($pages as $p) {
        $data = loadPage($basePath, $p, $lang);
        if ($data) {
            $sidebar[] = ['slug' => $p, 'title' => $data['title']];
        }
    }
    require "{$basePath}/views/show.php";
} else {
    http_response_code(404);
    echo 'Not found';
}
