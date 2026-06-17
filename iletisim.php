<?php
require_once __DIR__ . '/inc/helpers.php';
$iletisimMesaj = ''; $iletisimHata = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    csrf_check();
    $ad   = trim($_POST['ad'] ?? '');
    $mail = trim($_POST['mail'] ?? '');
    $tel  = trim($_POST['tel'] ?? '');
    $konu = trim($_POST['konu'] ?? '');
    $mes  = trim($_POST['mesaj'] ?? '');
    if(mb_strlen($ad) > 100 || mb_strlen($mail) > 150 || mb_strlen($tel) > 40 || mb_strlen($konu) > 200 || mb_strlen($mes) > 3000){
        $iletisimHata = 'Form alanları izin verilen uzunluğu aşıyor.';
    } elseif(!$ad || !$mail || !$mes){
        $iletisimHata = 'Ad, e-posta ve mesaj zorunludur.';
    } elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL)){
        $iletisimHata = 'Geçerli bir e-posta adresi giriniz.';
    } else {
        $stmt = $db->prepare("INSERT INTO mesajlar(ad,mail,tel,konu,mesaj) VALUES(?,?,?,?,?)");
        $stmt->execute([$ad,$mail,$tel,$konu,$mes]);
        $iletisimMesaj = 'Mesajınız başarıyla iletildi. En kısa sürede dönüş yapacağız.';
    }
}
require_once __DIR__ . '/inc/header.php';
?>
<section class="page-head">
  <div class="container">
    <h1>İletişim</h1>
    <nav><ol class="breadcrumb"><li class="breadcrumb-item"><a href="<?= SITE_URL ?>/">Anasayfa</a></li><li class="breadcrumb-item active">İletişim</li></ol></nav>
  </div>
</section>

<?php require_once __DIR__ . '/inc/iletisim-bolumu.php'; ?>

<?php require_once __DIR__ . '/inc/footer.php'; ?>
