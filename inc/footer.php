<footer>
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4 col-md-6">
        <div class="brand">
          <img src="<?= SITE_URL ?>/img/logo.jpg" alt="<?= e(ayar('site_adi')) ?>">
          <p><?= e(ayar('hakkimizda_kisa')) ?></p>
          <div class="social">
            <a href="<?= e(ayar('facebook')) ?>" target="_blank"><i class="bi bi-facebook"></i></a>
            <a href="<?= e(ayar('instagram')) ?>" target="_blank"><i class="bi bi-instagram"></i></a>
            <a href="<?= e(ayar('linkedin')) ?>" target="_blank"><i class="bi bi-linkedin"></i></a>
            <a href="<?= e(ayar('youtube')) ?>" target="_blank"><i class="bi bi-youtube"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-2 col-md-6">
        <h5>Kurumsal</h5>
        <a href="<?= SITE_URL ?>/hakkimizda">Hakkımızda</a>
        <a href="<?= SITE_URL ?>/hizmetler">Hizmetler</a>
        <a href="<?= SITE_URL ?>/projeler">Tesisler</a>
        <a href="<?= SITE_URL ?>/blog">Blog</a>
        <a href="<?= SITE_URL ?>/iletisim">İletişim</a>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5>Hizmetler</h5>
        <?php foreach (getList('hizmetler','durum=1','sira ASC',5) as $h): ?>
          <a href="<?= SITE_URL ?>/hizmet-detay?slug=<?= e($h['slug']) ?>"><?= e($h['baslik']) ?></a>
        <?php endforeach; ?>
      </div>
      <div class="col-lg-3 col-md-6">
        <h5>İletişim</h5>
        <div class="contact-li"><i class="bi bi-geo-alt-fill"></i><span><?= e(ayar('adres')) ?></span></div>
        <div class="contact-li"><i class="bi bi-telephone-fill"></i><a href="tel:<?= e(ayar('telefon')) ?>"><?= e(ayar('telefon')) ?></a></div>
        <div class="contact-li"><i class="bi bi-envelope-fill"></i><a href="mailto:<?= e(ayar('mail')) ?>"><?= e(ayar('mail')) ?></a></div>
        <div class="contact-li"><i class="bi bi-clock-fill"></i><span><?= e(ayar('calisma_saati')) ?></span></div>
      </div>
    </div>
    <div class="footer-bottom">
      &copy; <?= date('Y') ?> <?= e(ayar('site_adi')) ?>. Tüm hakları saklıdır.
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/js/main.js"></script>
</body>
</html>
