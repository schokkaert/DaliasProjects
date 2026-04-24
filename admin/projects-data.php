<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const DALIA_ADMIN_PROJECTS_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/projects.php';

function dalia_project_public(array $project): ?array
{
    $slug = trim((string) ($project['slug'] ?? ''));
    $title = trim((string) ($project['title'] ?? ''));
    if ($slug === '' || $title === '' || empty($project['active'])) {
        return null;
    }

    return [
        'slug' => $slug,
        'group' => trim((string) ($project['group'] ?? 'current')),
        'title' => $title,
        'location' => trim((string) ($project['location'] ?? '')),
        'type' => trim((string) ($project['type'] ?? '')),
        'status' => trim((string) ($project['status'] ?? '')),
        'sales_start' => trim((string) ($project['sales_start'] ?? '')),
        'highlight' => trim((string) ($project['highlight'] ?? '')),
        'sales_office' => trim((string) ($project['sales_office'] ?? '')),
        'sales_url' => trim((string) ($project['sales_url'] ?? '')),
        'summary' => trim((string) ($project['summary'] ?? '')),
        'quote' => trim((string) ($project['quote'] ?? '')),
        'context' => trim((string) ($project['context'] ?? '')),
        'hero' => trim((string) ($project['hero'] ?? '')),
        'gallery' => array_values(array_filter(
            is_array($project['gallery'] ?? null) ? $project['gallery'] : [],
            static fn (mixed $item): bool => trim((string) $item) !== ''
        )),
        'active' => true,
    ];
}

$projects = maatlas_admin_storage_read(DALIA_ADMIN_PROJECTS_FILE, []);
$public = array_values(array_filter(array_map(
    static fn (mixed $project): ?array => is_array($project) ? dalia_project_public($project) : null,
    $projects
)));

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo json_encode(['projects' => $public], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
