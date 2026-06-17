<?php
require_once __DIR__ . '/inc/helpers.php';
$slug = $_GET['slug'] ?? '';
$stmt = $db->prepare("SELECT * FROM projeler WHERE slug=? AND durum=1 LIMIT 1");
$stmt->execute([$slug]);
$p = $stmt->fetch();
if(!$p){ header('Location: projeler.php'); exit; }
$pageTitle = $p['baslik'] . ' — ' . ayar('site_adi');
$digerler = getList('projeler','durum=1 AND id<>'.(int)$p['id'],'sira ASC',6);
require_once __DIR__ . '/inc/header.php';
?>
<section class="page-head">
  <div class="container">
    <h1><?= e($p['baslik']) ?></h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/projeler">Tesisler</a></li><li class="breadcrumb-item active"><?= e($p['baslik']) ?></li></ol></nav>
  </div>
</section>
<section>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <img src="<?= e($p['gorsel']) ?>" class="w-100 rounded mb-4" alt="">
        <span class="badge-mini"><?= e($p['kategori']) ?> · <?= e($p['tarih']) ?></span>
        <h2><?= e($p['baslik']) ?></h2>
        <p class="lead"><?= e($p['aciklama']) ?></p>
      </div>
      <div class="col-lg-4">
        <div class="service-card">
          <h4>Diğer Tesisler</h4>
          <?php foreach($digerler as $d): ?>
            <a href="<?= SITE_URL ?>/proje-detay?slug=<?= e($d['slug']) ?>" class="d-flex gap-2 py-2" style="border-bottom:1px solid #eee">
              <img src="<?= e($d['gorsel']) ?>" style="width:60px;height:50px;object-fit:cover;border-radius:6px">
              <div><strong style="color:var(--dark);font-size:.9rem"><?= e($d['baslik']) ?></strong><br><small style="color:var(--gray)"><?= e($d['kategori']) ?></small></div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
