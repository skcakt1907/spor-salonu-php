<?php
require_once __DIR__ . '/auth.php';
$current = basename($_SERVER['SCRIPT_NAME']);
$adminTitle = $adminTitle ?? 'Yönetim Paneli';
$yeniMesaj = (int)$db->query("SELECT COUNT(*) FROM mesajlar WHERE okundu=0")->fetchColumn();
try { $yeniTeklif = (int)$db->query("SELECT COUNT(*) FROM teklifler WHERE durum='yeni'")->fetchColumn(); } catch(Exception $e){ $yeniTeklif=0; }
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<title><?= e($adminTitle) ?> — <?= e(ayar('site_adi')) ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
<style>
:root{--primary:#ea7c1c;--primary-dark:#c66514;--dark:#1f2937;--sidebar:#111827;--light:#f9fafb}
body{font-family:'Poppins',sans-serif;background:var(--light);margin:0}
.sidebar{position:fixed;left:0;top:0;bottom:0;width:250px;background:var(--sidebar);color:#cbd5e1;padding:1.4rem 0;overflow-y:auto}
.sidebar .brand{padding:0 1.4rem 1.4rem;border-bottom:1px solid #1f2937;margin-bottom:1rem;color:#fff;font-weight:700;font-size:1.25rem}
.sidebar .brand span{color:var(--primary)}
.sidebar a{display:flex;align-items:center;padding:.7rem 1.4rem;color:#cbd5e1;text-decoration:none;font-size:.92rem;transition:.2s;border-left:3px solid transparent}
.sidebar a i{margin-right:.7rem;width:18px}
.sidebar a:hover,.sidebar a.active{background:#1f2937;color:#fff;border-left-color:var(--primary)}
.sidebar a.active{color:var(--primary)}
.sidebar .badge{background:var(--primary);color:#fff;font-size:.7rem;margin-left:auto}
.main{margin-left:250px;padding:0}
.topbar{background:#fff;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;box-shadow:0 2px 6px rgba(0,0,0,.04)}
.topbar h1{font-size:1.25rem;margin:0;color:var(--dark)}
.topbar .user{color:var(--dark);font-weight:600}
.topbar .user i{color:var(--primary);margin-right:.4rem}
.content{padding:2rem}
.card{border:none;box-shadow:0 4px 16px rgba(0,0,0,.05);border-radius:12px}
.card-header{background:#fff;border-bottom:1px solid #f1f5f9;padding:1rem 1.4rem;font-weight:600;color:var(--dark);border-radius:12px 12px 0 0!important}
.btn-primary{background:var(--primary);border-color:var(--primary)}
.btn-primary:hover{background:var(--primary-dark);border-color:var(--primary-dark)}
.stat-card{background:#fff;padding:1.4rem;border-radius:12px;box-shadow:0 4px 16px rgba(0,0,0,.05);display:flex;align-items:center;gap:1rem}
.stat-card .icon{width:55px;height:55px;border-radius:12px;background:rgba(234,124,28,.12);color:var(--primary);display:flex;align-items:center;justify-content:center;font-size:1.6rem}
.stat-card h3{margin:0;color:var(--dark);font-size:1.7rem;font-weight:700}
.stat-card p{margin:0;color:#64748b;font-size:.9rem}
table thead th{background:#f8fafc;color:var(--dark);font-weight:600;border-bottom:2px solid #e2e8f0}
.table-hover tbody tr:hover{background:#fafbfc}
.form-control,.form-select{border-radius:8px;padding:.6rem .9rem;border:1px solid #e2e8f0}
.form-control:focus,.form-select:focus{border-color:var(--primary);box-shadow:0 0 0 .15rem rgba(234,124,28,.15)}
.form-label{font-weight:600;color:var(--dark);font-size:.9rem;margin-bottom:.4rem}
@media(max-width:768px){.sidebar{width:60px}.sidebar .brand,.sidebar a span{display:none}.main{margin-left:60px}}
</style>
</head>
<body>
<aside class="sidebar">
  <div class="brand"><?= e(ayar('site_adi')) ?> <span>Admin</span></div>
  <?php
  $menu = [
    'dashboard.php' => ['bi-speedometer2','Dashboard',0],
    'hizmetler.php' => ['bi-tools','Hizmetler',0],
    'projeler.php'  => ['bi-building','Projeler',0],
    'teklifler.php' => ['bi-clipboard-check','Teklifler',$yeniTeklif],
    'blog.php'      => ['bi-newspaper','Blog',0],
    'referanslar.php'=> ['bi-chat-quote','Referanslar',0],
    'mesajlar.php'  => ['bi-envelope','Mesajlar',$yeniMesaj],
    'ayarlar.php'   => ['bi-gear','Ayarlar',0],
  ];
  foreach($menu as $f=>$it):
    $active = (str_starts_with($current, explode('.',$f)[0])) ? 'active' : '';
  ?>
    <a href="<?= SITE_URL ?>/admin/<?= $f ?>" class="<?= $active ?>"><i class="bi <?= $it[0] ?>"></i><span><?= $it[1] ?></span><?php if($it[2]): ?><span class="badge"><?= $it[2] ?></span><?php endif; ?></a>
  <?php endforeach; ?>
  <a href="<?= SITE_URL ?>/" target="_blank"><i class="bi bi-eye"></i><span>Siteyi Görüntüle</span></a>
  <a href="<?= SITE_URL ?>/admin/logout.php"><i class="bi bi-box-arrow-right"></i><span>Çıkış Yap</span></a>
</aside>
<main class="main">
  <div class="topbar">
    <h1><?= e($adminTitle) ?></h1>
    <div class="user"><i class="bi bi-person-circle"></i><?= e($adminAd) ?></div>
  </div>
  <div class="content">
