<?php
require_once __DIR__ . '/inc/helpers.php';
$slug = $_GET['slug'] ?? '';
$stmt = $db->prepare("SELECT * FROM hizmetler WHERE slug=? AND durum=1 LIMIT 1");
$stmt->execute([$slug]);
$h = $stmt->fetch();
if(!$h){ header('Location: hizmetler.php'); exit; }
$pageTitle = $h['baslik'] . ' — ' . ayar('site_adi');
$digerler = getList('hizmetler','durum=1 AND id<>'.(int)$h['id'],'sira ASC',6);
require_once __DIR__ . '/inc/header.php';
?>
<section class="page-head">
  <div class="container">
    <h1><?= e($h['baslik']) ?></h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/hizmetler">Hizmetler</a></li><li class="breadcrumb-item active"><?= e($h['baslik']) ?></li></ol></nav>
  </div>
</section>

<section>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <?php if($h['gorsel']): ?><img src="<?= e($h['gorsel']) ?>" class="w-100 rounded mb-4" alt=""><?php endif; ?>
        <span class="badge-mini"><?= e($h['baslik']) ?></span>
        <h2><?= e($h['baslik']) ?></h2>
        <p class="lead"><?= e($h['ozet']) ?></p>
        <div><?= nl2br(e($h['icerik'])) ?></div>
      </div>
      <div class="col-lg-4">
        <div class="service-card mb-4">
          <h4>Diğer Hizmetlerimiz</h4>
          <?php foreach($digerler as $d): ?>
            <a href="<?= SITE_URL ?>/hizmet-detay?slug=<?= e($d['slug']) ?>" class="d-block py-2" style="border-bottom:1px solid #eee"><i class="bi <?= e($d['ikon']) ?> me-2" style="color:var(--primary)"></i><?= e($d['baslik']) ?></a>
          <?php endforeach; ?>
        </div>
        <div class="cta p-4 rounded text-center">
          <h5 style="color:#fff">Teklif Almak İster misiniz?</h5>
          <a href="<?= SITE_URL ?>/iletisim" class="btn mt-2">İletişim</a>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
