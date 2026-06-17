<?php
// Reusable iletişim bölümü — hem iletisim.php hem index.php sonunda kullanılır
// $iletisimMesaj ve $iletisimHata değişkenleri varsa (iletisim.php'den) üstte gösterilir
?>
<section id="iletisim" style="background:#f4f4f5">
  <div class="container">
    <div class="section-head center">
      <span class="mini">İletişim</span>
      <h2>Bizimle <span>İletişime Geçin</span></h2>
      <p class="desc">Sorularınız, projeleriniz veya teklif talebiniz için bize ulaşın. En kısa sürede dönüş yapacağız.</p>
    </div>

    <div class="row g-4 mb-4">
      <div class="col-md-4"><div class="contact-info-card"><i class="bi bi-geo-alt-fill"></i><h5>Adres</h5><p><?= e(ayar('adres')) ?></p></div></div>
      <div class="col-md-4">
        <div class="contact-info-card">
          <i class="bi bi-telephone-fill"></i>
          <h5>Telefon</h5>
          <p>
            <a href="tel:<?= e(ayar('telefon')) ?>" style="color:var(--gray)"><?= e(ayar('telefon')) ?></a><br>
            <a href="tel:<?= e(ayar('telefon2')) ?>" style="color:var(--gray)"><?= e(ayar('telefon2')) ?></a>
          </p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="contact-info-card">
          <i class="bi bi-envelope-fill"></i>
          <h5>E-posta &amp; Çalışma</h5>
          <p>
            <a href="mailto:<?= e(ayar('mail')) ?>" style="color:var(--gray)"><?= e(ayar('mail')) ?></a><br>
            <small><?= e(ayar('calisma_saati')) ?></small>
          </p>
        </div>
      </div>
    </div>

    <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div style="background:#fff;padding:2rem;border-radius:8px;border:1px solid #f3f4f6;height:100%">
          <h4 style="margin-bottom:.4rem">Mesaj Gönderin</h4>
          <p class="text-muted" style="font-size:.92rem;margin-bottom:1.5rem">Form üzerinden ulaşın, en kısa sürede dönüş yapalım.</p>
          <?php if(!empty($iletisimMesaj)): ?><div class="alert alert-success"><?= e($iletisimMesaj) ?></div><?php endif; ?>
          <?php if(!empty($iletisimHata)):  ?><div class="alert alert-danger"><?= e($iletisimHata) ?></div><?php endif; ?>
          <form method="post" action="<?= SITE_URL ?>/iletisim#iletisim" class="contact-form">
            <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
            <div class="row g-3">
              <div class="col-md-6"><input class="form-control" name="ad" placeholder="Adınız Soyadınız" required maxlength="100"></div>
              <div class="col-md-6"><input class="form-control" type="email" name="mail" placeholder="E-posta" required maxlength="150"></div>
              <div class="col-md-6"><input class="form-control" name="tel" placeholder="Telefon" maxlength="40"></div>
              <div class="col-md-6"><input class="form-control" name="konu" placeholder="Konu" maxlength="200"></div>
              <div class="col-12"><textarea class="form-control" name="mesaj" rows="5" placeholder="Mesajınız" required maxlength="3000"></textarea></div>
              <div class="col-12"><button class="btn btn-orange">Gönder <i class="bi bi-send ms-2"></i></button></div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="ratio ratio-4x3 rounded overflow-hidden h-100">
          <iframe src="https://www.google.com/maps?q=<?= urlencode(ayar('adres')) ?>&output=embed" loading="lazy" style="border:0;min-height:380px"></iframe>
        </div>
      </div>
    </div>
  </div>
</section>
