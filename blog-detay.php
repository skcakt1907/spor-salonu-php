<?php
require_once __DIR__ . '/inc/helpers.php';
$slug = $_GET['slug'] ?? '';
$stmt = $db->prepare("SELECT * FROM blog WHERE slug=? AND durum=1 LIMIT 1");
$stmt->execute([$slug]);
$b = $stmt->fetch();
if(!$b){ header('Location: blog.php'); exit; }
$pageTitle = $b['baslik'];
$diger = getList('blog','durum=1 AND id<>'.(int)$b['id'],'tarih DESC',4);
require_once __DIR__ . '/inc/header.php';
?>
<section class="page-head">
  <div class="container">
    <h1><?= e($b['baslik']) ?></h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/blog">Blog</a></li><li class="breadcrumb-item active"><?= e($b['baslik']) ?></li></ol></nav>
  </div>
</section>
<section>
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-8">
        <img src="<?= e($b['gorsel']) ?>" class="w-100 rounded mb-4" alt="">
        <div class="blog-meta mb-2"><i class="bi bi-calendar3"></i><?= trTarih($b['tarih']) ?> <span class="ms-2"><i class="bi bi-tag"></i><?= e($b['kategori']) ?></span></div>
        <h2><?= e($b['baslik']) ?></h2>
        <p class="lead"><?= e($b['ozet']) ?></p>
        <div><?= nl2br(e($b['icerik'])) ?></div>
      </div>
      <div class="col-lg-4">
        <div class="service-card">
          <h4>Diğer Yazılar</h4>
          <?php foreach($diger as $d): ?>
            <a href="<?= SITE_URL ?>/blog-detay?slug=<?= e($d['slug']) ?>" class="d-flex gap-2 py-2" style="border-bottom:1px solid #eee">
              <img src="<?= e($d['gorsel']) ?>" style="width:70px;height:55px;object-fit:cover;border-radius:6px">
              <div><strong style="color:var(--dark);font-size:.9rem"><?= e($d['baslik']) ?></strong><br><small style="color:var(--gray)"><?= trTarih($d['tarih']) ?></small></div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
