<?php

declare(strict_types=1);

const DB_FILE = __DIR__ . '/data/partner_hub.sqlite';
const DEFAULT_COMMISSION = 40.0;
const APP_NAME = 'Partner Sales Hub';

if (!is_dir(__DIR__ . '/data')) {
    mkdir(__DIR__ . '/data', 0755, true);
}

$db = new PDO('sqlite:' . DB_FILE);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$db->exec('PRAGMA foreign_keys = ON');

session_start();

function db(): PDO { global $db; return $db; }
function e(?string $v): string { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function user(): ?array { return $_SESSION['user'] ?? null; }
function require_login(): void { if (!user()) redirect('index.php'); }
function require_role(string $role): void { require_login(); if ((user()['role'] ?? '') !== $role) http_response_code(403) && exit('Access denied'); }
function slugify(string $text): string { $text = strtolower(trim($text)); $text = preg_replace('/[^a-z0-9]+/i', '-', iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text) ?: $text); return trim($text, '-'); }
function layout_start(string $title): void { echo '<!doctype html><html lang="it"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.e($title).' · '.APP_NAME.'</title><style>'.css().'</style></head><body><header><a class="brand" href="index.php">'.APP_NAME.'</a><nav>'; if (user()) { echo user()['role']==='admin' ? '<a href="admin.php">Admin</a>' : '<a href="partner.php">Partner</a>'; echo '<a href="logout.php">Esci</a>'; } echo '</nav></header><main>'; }
function layout_end(): void { echo '</main><footer>Partner Sales Hub · MVP</footer></body></html>'; }
function css(): string { return 'body{margin:0;background:#f5f7fb;color:#172033;font:15px system-ui,-apple-system,Segoe UI,sans-serif}header{height:64px;background:#111827;color:#fff;display:flex;align-items:center;justify-content:space-between;padding:0 6%;box-sizing:border-box}.brand{color:#fff;text-decoration:none;font-weight:800;font-size:18px}nav a{color:#dbe4f0;text-decoration:none;margin-left:20px}.container{max-width:1120px;margin:35px auto;padding:0 20px}.card{background:#fff;border:1px solid #e6eaf0;border-radius:16px;padding:22px;box-shadow:0 4px 20px #00000008;margin-bottom:20px}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:18px}.stat{font-size:28px;font-weight:800}.muted{color:#667085}.btn{display:inline-block;background:#2563eb;color:#fff;padding:11px 16px;border-radius:9px;text-decoration:none;border:0;cursor:pointer}.btn.secondary{background:#e9eef8;color:#172033}input,textarea,select{width:100%;padding:11px;border:1px solid #d5dbe5;border-radius:9px;box-sizing:border-box;margin:6px 0 14px}label{font-weight:650}table{width:100%;border-collapse:collapse}th,td{text-align:left;padding:12px;border-bottom:1px solid #edf0f4}.hero{background:linear-gradient(135deg,#111827,#334155);color:#fff;border-radius:22px;padding:45px}.pill{display:inline-block;padding:5px 9px;border-radius:99px;background:#eef2ff;color:#3730a3;font-size:12px;font-weight:700}footer{text-align:center;color:#98a2b3;padding:40px}h1{font-size:36px;line-height:1.1}h2{margin-top:0}@media(max-width:600px){h1{font-size:28px}}'; }
