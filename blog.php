<?php require_once __DIR__ . '/inc/header.php'; $yazilar = getList('blog','durum=1','tarih DESC'); ?>
<section class="page-head">
  <div class="container">
    <h1>Blog</h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item active">Blog</li></ol></nav>
  </div>
</section>
<section>
  <div class="container">
    <div class="row g-4">
      <?php foreach($yazilar as $b): ?>
      <div class="col-lg-4 col-md-6">
        <div class="blog-card">
          <img src="<?= e($b['gorsel']) ?>" alt="">
          <div class="blog-body">
            <div class="blog-meta"><i class="bi bi-calendar3"></i><?= trTarih($b['tarih']) ?> <span class="ms-2"><i class="bi bi-tag"></i><?= e($b['kategori']) ?></span></div>
            <h5><a href="<?= SITE_URL ?>/blog-detay?slug=<?= e($b['slug']) ?>"><?= e($b['baslik']) ?></a></h5>
            <p><?= e($b['ozet']) ?></p>
            <a href="<?= SITE_URL ?>/blog-detay?slug=<?= e($b['slug']) ?>" style="color:var(--primary);font-weight:600">Devamı <i class="bi bi-arrow-right"></i></a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
