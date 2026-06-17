<?php
require_once __DIR__ . '/helpers.php';
$current = basename($_SERVER['SCRIPT_NAME']);
$pageTitle = $pageTitle ?? ayar('site_baslik');
$hizmetMenu = getList('hizmetler','durum=1','sira ASC');
?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($pageTitle) ?></title>
<meta name="description" content="<?= e(ayar('site_aciklama')) ?>">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
<link href="<?= SITE_URL ?>/css/style.css" rel="stylesheet">
</head>
<body>
<div class="nav-spacer"></div>
<nav class="navbar navbar-expand-lg">
  <div class="container">
    <a class="navbar-brand" href="<?= SITE_URL ?>/"><img src="<?= SITE_URL ?>/img/logo.jpg" alt="<?= e(ayar('site_adi')) ?>"></a>
    <button class="navbar-toggler border-0" data-bs-toggle="collapse" data-bs-target="#nav"><i class="bi bi-list text-white" style="font-size:1.8rem"></i></button>
    <div class="collapse navbar-collapse" id="nav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link <?= $current==='index.php'?'active':'' ?>" href="<?= SITE_URL ?>/">Anasayfa</a></li>
        <li class="nav-item"><a class="nav-link <?= $current==='hakkimizda.php'?'active':'' ?>" href="<?= SITE_URL ?>/hakkimizda">Hakkımızda</a></li>
        <li class="nav-item nav-dropdown">
          <a class="nav-link <?= in_array($current,['hizmetler.php','hizmet-detay.php'])?'active':'' ?>" href="<?= SITE_URL ?>/hizmetler">Hizmetlerimiz <i class="bi bi-chevron-down ms-1" style="font-size:.7rem"></i></a>
          <div class="dropdown-panel">
            <?php foreach($hizmetMenu as $hm): ?>
              <a href="<?= SITE_URL ?>/hizmet-detay?slug=<?= e($hm['slug']) ?>"><i class="bi <?= e($hm['ikon']) ?>"></i><span><?= e($hm['baslik']) ?></span></a>
            <?php endforeach; ?>
          </div>
        </li>
        <li class="nav-item"><a class="nav-link <?= in_array($current,['projeler.php','proje-detay.php'])?'active':'' ?>" href="<?= SITE_URL ?>/projeler">Tesislerimiz</a></li>
        <li class="nav-item"><a class="nav-link <?= in_array($current,['blog.php','blog-detay.php'])?'active':'' ?>" href="<?= SITE_URL ?>/blog">Blog</a></li>
        <li class="nav-item"><a class="nav-link <?= $current==='iletisim.php'?'active':'' ?>" href="<?= SITE_URL ?>/iletisim">İletişim</a></li>
        <li class="nav-item"><a class="nav-link nav-cta" href="<?= SITE_URL ?>/teklif">Teklif Al <i class="bi bi-arrow-right ms-1"></i></a></li>
      </ul>
    </div>
  </div>
</nav>
