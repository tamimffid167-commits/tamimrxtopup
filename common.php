<?php
declare(strict_types=1);
session_start();
$configFile = __DIR__ . '/config.php';
if (!is_file($configFile)) { http_response_code(500); exit('config.php নেই। README অনুসরণ করে config.sample.php কপি করুন।'); }
$config = require $configFile;
$dataFile = __DIR__ . '/data/orders.json';
if (!is_dir(__DIR__ . '/data')) mkdir(__DIR__ . '/data', 0750, true);
if (!is_file($dataFile)) file_put_contents($dataFile, '[]', LOCK_EX);
function h($v): string { return htmlspecialchars((string)$v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function csrf(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function check_csrf(): void { if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) { http_response_code(419); exit('Session expired. ফিরে গিয়ে আবার চেষ্টা করুন।'); } }
function orders_read(): array { global $dataFile; $v = json_decode((string)file_get_contents($dataFile), true); return is_array($v) ? $v : []; }
function orders_write(array $orders): void { global $dataFile; $tmp = $dataFile . '.tmp'; file_put_contents($tmp, json_encode($orders, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE), LOCK_EX); rename($tmp, $dataFile); }
function page_start(string $title): void { global $config; echo '<!doctype html><html lang="bn"><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>'.h($title).' - '.h($config['site_name']).'</title><style>body{font-family:system-ui,Arial;background:#f3f6fb;color:#172033;margin:0;padding:20px}.wrap{max-width:680px;margin:25px auto}.card{background:white;border:1px solid #dce4f0;border-radius:18px;padding:22px;box-shadow:0 8px 24px #10204010}h1{font-size:24px;margin:0 0 8px}label{display:block;font-weight:650;margin:14px 0 6px}input,select{width:100%;box-sizing:border-box;padding:13px;border:1px solid #cbd5e1;border-radius:10px;font:inherit}button,.btn{display:inline-block;border:0;border-radius:10px;background:#2459d3;color:white;padding:13px 18px;font-weight:700;text-decoration:none;cursor:pointer;width:100%;margin-top:18px}small,.muted{color:#64748b}.method{padding:12px;background:#eef4ff;border-radius:12px;margin:12px 0}.ok{background:#eafaf0;padding:12px;border-radius:10px}.bad{background:#fff1f0;padding:12px;border-radius:10px}table{width:100%;border-collapse:collapse;font-size:14px}td,th{padding:9px;border-bottom:1px solid #e2e8f0;text-align:left}a{color:#2459d3}</style><div class="wrap">'; }
function page_end(): void { echo '</div></html>'; }
