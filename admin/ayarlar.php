<?php
$adminTitle='Site Ayarları';
require_once __DIR__ . '/inc/crud.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check();
    foreach($_POST as $k=>$v){
        if($k==='csrf') continue;
        $stmt = $db->prepare("INSERT INTO ayarlar(anahtar,deger) VALUES(?,?) ON DUPLICATE KEY UPDATE deger=VALUES(deger)");
        $stmt->execute([$k, $v]);
    }
    adminFlash('Ayarlar kaydedildi.');
    header('Location: ' . SITE_URL . '/admin/ayarlar.php'); exit;
}
$tum = $db->query("SELECT * FROM ayarlar")->fetchAll();
$a = []; foreach($tum as $r) $a[$r['anahtar']]=$r['deger'];
$flash = adminFlashCek();
require_once __DIR__ . '/inc/header.php';
?>
<?php if($flash): ?><div class="alert alert-success"><?= e($flash['msg']) ?></div><?php endif; ?>
<form method="post" class="card p-4">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <h5 class="mb-3"><i class="bi bi-building me-2"></i>Genel Bilgiler</h5>
  <div class="row g-3 mb-4">
    <div class="col-md-6"><label class="form-label">Site Adı</label><input class="form-control" name="site_adi" value="<?= e($a['site_adi']??'') ?>"></div>
    <div class="col-md-6"><label class="form-label">Site Başlık (SEO)</label><input class="form-control" name="site_baslik" value="<?= e($a['site_baslik']??'') ?>"></div>
    <div class="col-12"><label class="form-label">Site Açıklama (SEO)</label><textarea class="form-control" name="site_aciklama" rows="2"><?= e($a['site_aciklama']??'') ?></textarea></div>
  </div>

  <h5 class="mb-3"><i class="bi bi-telephone me-2"></i>İletişim</h5>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><label class="form-label">Telefon 1</label><input class="form-control" name="telefon" value="<?= e($a['telefon']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">Telefon 2</label><input class="form-control" name="telefon2" value="<?= e($a['telefon2']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">E-posta</label><input class="form-control" type="email" name="mail" value="<?= e($a['mail']??'') ?>"></div>
    <div class="col-md-8"><label class="form-label">Adres</label><input class="form-control" name="adres" value="<?= e($a['adres']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">Çalışma Saati</label><input class="form-control" name="calisma_saati" value="<?= e($a['calisma_saati']??'') ?>"></div>
  </div>

  <h5 class="mb-3"><i class="bi bi-info-circle me-2"></i>Hakkımızda</h5>
  <div class="row g-3 mb-4">
    <div class="col-12"><label class="form-label">Hakkımızda (kısa)</label><textarea class="form-control" name="hakkimizda_kisa" rows="2"><?= e($a['hakkimizda_kisa']??'') ?></textarea></div>
    <div class="col-12"><label class="form-label">Hakkımızda (uzun)</label><textarea class="form-control" name="hakkimizda_uzun" rows="5"><?= e($a['hakkimizda_uzun']??'') ?></textarea></div>
    <div class="col-md-6"><label class="form-label">Misyon</label><textarea class="form-control" name="misyon" rows="3"><?= e($a['misyon']??'') ?></textarea></div>
    <div class="col-md-6"><label class="form-label">Vizyon</label><textarea class="form-control" name="vizyon" rows="3"><?= e($a['vizyon']??'') ?></textarea></div>
  </div>

  <h5 class="mb-3"><i class="bi bi-bar-chart me-2"></i>Sayaçlar</h5>
  <div class="row g-3 mb-4">
    <div class="col-md-3"><label class="form-label">Yıllık Tecrübe</label><input class="form-control" name="yil" value="<?= e($a['yil']??'') ?>"></div>
    <div class="col-md-3"><label class="form-label">Proje Sayısı</label><input class="form-control" name="proje_sayi" value="<?= e($a['proje_sayi']??'') ?>"></div>
    <div class="col-md-3"><label class="form-label">Müşteri Sayısı</label><input class="form-control" name="musteri_sayi" value="<?= e($a['musteri_sayi']??'') ?>"></div>
    <div class="col-md-3"><label class="form-label">Personel Sayısı</label><input class="form-control" name="personel_sayi" value="<?= e($a['personel_sayi']??'') ?>"></div>
  </div>

  <h5 class="mb-3"><i class="bi bi-share me-2"></i>Sosyal Medya</h5>
  <div class="row g-3 mb-4">
    <div class="col-md-4"><label class="form-label">Facebook</label><input class="form-control" name="facebook" value="<?= e($a['facebook']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">Instagram</label><input class="form-control" name="instagram" value="<?= e($a['instagram']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">Twitter/X</label><input class="form-control" name="twitter" value="<?= e($a['twitter']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">LinkedIn</label><input class="form-control" name="linkedin" value="<?= e($a['linkedin']??'') ?>"></div>
    <div class="col-md-4"><label class="form-label">YouTube</label><input class="form-control" name="youtube" value="<?= e($a['youtube']??'') ?>"></div>
  </div>

  <button class="btn btn-primary"><i class="bi bi-save"></i> Tüm Ayarları Kaydet</button>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
