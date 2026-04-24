# Dalia Projects rebuild

PHP-based rebuild of the Dalia Projects website with shared includes and admin-backed content.

## Pages

- `index.php`
- `projecten.php`
- `over.php`
- `grond-gezocht.php`
- `contact.php`
- `cookies.php`
- `voorwaarden.php`
- `project.php?slug=...`
- `admin/`

## Notes

- The design uses the same warm paper background, dark typography and red accent language as the live site.
- Shared public layout is handled through `includes/header.php`, `includes/footer.php` and `includes/site.php`.
- The project cards and project detail pages are data-driven through the PHP storage layer.
- The cookie banner is local-only and stored in `localStorage`.
- The admin area is a separate PHP folder with session-based login, CSRF checks, hashed passwords and activation links.
- On first run, `/admin/login.php` creates a temporary `admin` / `admin` login until the first real superadmin is created.
- Social links are managed from `/admin/` and exposed to the public site through `admin/settings.php`.
