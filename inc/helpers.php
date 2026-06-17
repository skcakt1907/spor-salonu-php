<?php
require_once __DIR__ . '/db.php';

// XSS koruma
function e($s) { return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

// Site ayarlarını tek seferde belleğe al
function ayarlar() {
    static $cache = null;
    if ($cache === null) {
        global $db;
        $cache = [];
        foreach ($db->query("SELECT anahtar, deger FROM ayarlar") as $r) {
            $cache[$r['anahtar']] = $r['deger'];
        }
    }
    return $cache;
}
function ayar($k, $varsayilan = '') {
    $a = ayarlar();
    return $a[$k] ?? $varsayilan;
}

// Liste çekme yardımcısı
function getList($tablo, $where = '1', $order = 'sira ASC, id DESC', $limit = null) {
    global $db;
    $sql = "SELECT * FROM `$tablo` WHERE $where ORDER BY $order";
    if ($limit) $sql .= " LIMIT " . (int)$limit;
    return $db->query($sql)->fetchAll();
}

// CSRF token
function csrf_token() {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function csrf_check() {
    if (($_POST['csrf'] ?? '') !== ($_SESSION['csrf'] ?? '_')) {
        die('Geçersiz form gönderimi (CSRF).');
    }
}

// Tarih formatla
function trTarih($d) {
    if (!$d) return '';
    $aylar = ['','Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
    $t = strtotime($d);
    return date('d', $t) . ' ' . $aylar[(int)date('m', $t)] . ' ' . date('Y', $t);
}

// Slug üret
function slugify($s) {
    $tr = ['ç','Ç','ğ','Ğ','ı','İ','ö','Ö','ş','Ş','ü','Ü'];
    $en = ['c','c','g','g','i','i','o','o','s','s','u','u'];
    $s = str_replace($tr, $en, $s);
    $s = strtolower(trim($s));
    $s = preg_replace('/[^a-z0-9]+/', '-', $s);
    return trim($s, '-');
}
