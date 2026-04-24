<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const MAATLAS_ADMIN_PAGE_CONTENT_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/page-content.php';

function maatlas_admin_content_page_key(string $value): string
{
    $page = basename(trim($value));
    if ($page === '' || $page === '.' || $page === '/') {
        return 'index.php';
    }

    if (!preg_match('~^[a-z0-9._-]+\.(html|php)$~i', $page)) {
        return 'index.php';
    }

    return $page;
}

function maatlas_admin_read_page_content(): array
{
    return maatlas_admin_storage_read(MAATLAS_ADMIN_PAGE_CONTENT_FILE, ['pages' => []]);
}

function maatlas_admin_save_page_content(array $content): void
{
    maatlas_admin_storage_write(MAATLAS_ADMIN_PAGE_CONTENT_FILE, [
        'pages' => is_array($content['pages'] ?? null) ? $content['pages'] : [],
    ]);
}

function maatlas_admin_json(array $payload, int $status = 200): never
{
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    echo json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

$page = maatlas_admin_content_page_key((string) ($_GET['page'] ?? $_POST['page'] ?? 'index.php'));
$content = maatlas_admin_read_page_content();
$admin = maatlas_admin_current_admin();
$canEdit = is_array($admin) && empty($admin['temporary']);

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    maatlas_admin_json([
        'authenticated' => $canEdit,
        'csrf' => $canEdit ? maatlas_admin_csrf_token() : null,
        'page' => $page,
        'content' => is_array($content['pages'][$page] ?? null) ? $content['pages'][$page] : [],
    ]);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    maatlas_admin_json(['ok' => false, 'message' => 'Methode niet toegestaan.'], 405);
}

if (!$canEdit) {
    maatlas_admin_json(['ok' => false, 'message' => 'Niet aangemeld.'], 403);
}

maatlas_admin_require_csrf();

$rawUpdates = (string) ($_POST['updates'] ?? '');
$updates = json_decode($rawUpdates, true);
if (!is_array($updates)) {
    maatlas_admin_json(['ok' => false, 'message' => 'Ongeldige inhoud.'], 400);
}

$clean = [];
foreach ($updates as $key => $value) {
    $cleanKey = preg_replace('~[^a-z0-9_-]~i', '', (string) $key);
    if ($cleanKey === '') {
        continue;
    }

    $text = trim((string) $value);
    $clean[$cleanKey] = function_exists('mb_substr') ? mb_substr($text, 0, 5000) : substr($text, 0, 5000);
}

$content['pages'][$page] = $clean;
maatlas_admin_save_page_content($content);

maatlas_admin_json([
    'ok' => true,
    'page' => $page,
    'content' => $clean,
]);
