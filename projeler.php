<?php require_once __DIR__ . '/inc/header.php'; $projeler = getList('projeler','durum=1','sira ASC'); $kategoriler = array_unique(array_column($projeler,'kategori')); ?>
<section class="page-head">
  <div class="container">
    <h1>Tesislerimiz</h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item active">Tesisler</li></ol></nav>
  </div>
</section>

<section>
  <div class="container">
    <div class="section-head">
      <span class="badge-mini">Çalışmalarımız</span>
      <h2>Modern <span>Tesislerimiz</span></h2>
    </div>
    <div class="text-center mb-4">
      <button class="btn btn-outline-secondary btn-sm me-2 filter-btn active" data-f="all">Tümü</button>
      <?php foreach($kategoriler as $k): ?>
        <button class="btn btn-outline-secondary btn-sm me-2 filter-btn" data-f="<?= e($k) ?>"><?= e($k) ?></button>
      <?php endforeach; ?>
    </div>
    <div class="row g-4" id="projeGrid">
      <?php foreach($projeler as $p): ?>
      <div class="col-lg-4 col-md-6 proje-item" data-cat="<?= e($p['kategori']) ?>">
        <a class="project d-block" href="<?= SITE_URL ?>/proje-detay?slug=<?= e($p['slug']) ?>">
          <img src="<?= e($p['gorsel']) ?>" alt="<?= e($p['baslik']) ?>">
          <div class="project-overlay"><div><span><?= e($p['kategori']) ?> · <?= e($p['tarih']) ?></span><h5><?= e($p['baslik']) ?></h5></div></div>
        </a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<script>
document.querySelectorAll('.filter-btn').forEach(b => b.addEventListener('click', e => {
  document.querySelectorAll('.filter-btn').forEach(x => x.classList.remove('active'));
  b.classList.add('active');
  const f = b.dataset.f;
  document.querySelectorAll('.proje-item').forEach(i => {
    i.style.display = (f === 'all' || i.dataset.cat === f) ? '' : 'none';
  });
}));
</script>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
