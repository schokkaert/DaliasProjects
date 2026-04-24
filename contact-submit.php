<?php
declare(strict_types=1);

const DALIA_CONTACT_RECIPIENT = 'info@daliasprojects.be';

function dalia_contact_clean(string $value, int $max = 2000): string
{
    $value = trim(str_replace(["\r", "\0"], '', $value));
    return function_exists('mb_substr') ? mb_substr($value, 0, $max) : substr($value, 0, $max);
}

function dalia_contact_redirect(bool $ok): never
{
    $fallback = './contact.php';
    $referer = (string) ($_SERVER['HTTP_REFERER'] ?? '');
    $target = preg_match('~/(contact|grond-gezocht)\.(html|php)~', $referer) ? $referer : $fallback;
    $separator = str_contains($target, '?') ? '&' : '?';
    header('Location: ' . $target . $separator . 'sent=' . ($ok ? '1' : '0'));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    dalia_contact_redirect(false);
}

$subjectType = dalia_contact_clean((string) ($_POST['subject_type'] ?? ''), 120);
$project = dalia_contact_clean((string) ($_POST['project'] ?? ''), 180);
$name = dalia_contact_clean((string) ($_POST['name'] ?? ''), 180);
$email = dalia_contact_clean((string) ($_POST['email'] ?? ''), 180);
$phone = dalia_contact_clean((string) ($_POST['phone'] ?? ''), 80);
$message = dalia_contact_clean((string) ($_POST['message'] ?? ''), 4000);

if ($name === '' || $email === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    dalia_contact_redirect(false);
}

$subject = 'Website aanvraag Dalia Projects';
if ($subjectType !== '') {
    $subject .= ' - ' . $subjectType;
}

$body = implode("\n", [
    'Nieuwe aanvraag via daliaprojects.digisteps.be',
    '',
    'Onderwerp: ' . ($subjectType ?: 'Niet opgegeven'),
    'Project / ligging: ' . ($project ?: 'Niet opgegeven'),
    'Naam: ' . $name,
    'E-mail: ' . $email,
    'Telefoon: ' . ($phone ?: 'Niet opgegeven'),
    '',
    'Bericht:',
    $message,
]);

$headers = [
    'From: Dalia Projects <' . DALIA_CONTACT_RECIPIENT . '>',
    'Reply-To: ' . $email,
    'Content-Type: text/plain; charset=UTF-8',
];

$sent = mail(DALIA_CONTACT_RECIPIENT, $subject, $body, implode("\r\n", $headers));
dalia_contact_redirect($sent);
