<?php
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

const DALIA_ADMIN_PERSONNEL_FILE = MAATLAS_ADMIN_STORAGE_DIR . '/personnel.php';

$items = maatlas_admin_storage_read(DALIA_ADMIN_PERSONNEL_FILE, []);
$public = [];

foreach ($items as $person) {
    if (!is_array($person) || empty($person['active'])) {
        continue;
    }

    $public[] = [
        'id' => trim((string) ($person['id'] ?? '')),
        'name' => trim((string) ($person['name'] ?? '')),
        'roles' => array_values(array_filter(is_array($person['roles'] ?? null) ? $person['roles'] : [])),
        'biv' => trim((string) ($person['biv'] ?? '')),
        'phone' => trim((string) ($person['phone'] ?? '')),
        'email' => trim((string) ($person['email'] ?? '')),
        'photo' => trim((string) ($person['photo'] ?? '')),
        'active' => true,
    ];
}

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
echo json_encode(['personnel' => $public], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
