<?php
require_once __DIR__ . '/inc/crud.php';
$id = (int)($_GET['id'] ?? 0);
$h = ['id'=>0,'baslik'=>'','slug'=>'','ozet'=>'','icerik'=>'','ikon'=>'bi-building','gorsel'=>'','sira'=>0,'durum'=>1];
if($id){ $stmt = $db->prepare("SELECT * FROM hizmetler WHERE id=?"); $stmt->execute([$id]); $h = $stmt->fetch() ?: $h; }

if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check();
    $data = [
        'baslik'  => trim($_POST['baslik']),
        'slug'    => slugify($_POST['slug'] ?: $_POST['baslik']),
        'ozet'    => trim($_POST['ozet']),
        'icerik'  => trim($_POST['icerik']),
        'ikon'    => trim($_POST['ikon'] ?: 'bi-building'),
        'gorsel'  => adminGorselYukle('gorsel_file', $h['gorsel']),
        'sira'    => (int)$_POST['sira'],
        'durum'   => isset($_POST['durum'])?1:0,
    ];
    if($id){
        $stmt = $db->prepare("UPDATE hizmetler SET baslik=:baslik,slug=:slug,ozet=:ozet,icerik=:icerik,ikon=:ikon,gorsel=:gorsel,sira=:sira,durum=:durum WHERE id=:id");
        $data['id']=$id; $stmt->execute($data);
        adminFlash('Hizmet güncellendi.');
    } else {
        $stmt = $db->prepare("INSERT INTO hizmetler(baslik,slug,ozet,icerik,ikon,gorsel,sira,durum) VALUES(:baslik,:slug,:ozet,:icerik,:ikon,:gorsel,:sira,:durum)");
        $stmt->execute($data);
        adminFlash('Hizmet eklendi.');
    }
    header('Location: ' . SITE_URL . '/admin/hizmetler.php'); exit;
}
$adminTitle = $id ? 'Hizmet Düzenle' : 'Yeni Hizmet';
require_once __DIR__ . '/inc/header.php';
?>
<form method="post" enctype="multipart/form-data" class="card p-4">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label">Başlık *</label><input class="form-control" name="baslik" value="<?= e($h['baslik']) ?>" required></div>
    <div class="col-md-4"><label class="form-label">Slug (boş bırakırsanız otomatik)</label><input class="form-control" name="slug" value="<?= e($h['slug']) ?>"></div>
    <div class="col-md-6"><label class="form-label">İkon (bootstrap-icons class)</label><input class="form-control" name="ikon" value="<?= e($h['ikon']) ?>" placeholder="bi-hammer"></div>
    <div class="col-md-3"><label class="form-label">Sıra</label><input type="number" class="form-control" name="sira" value="<?= (int)$h['sira'] ?>"></div>
    <div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" class="form-check-input" id="durum" name="durum" <?= $h['durum']?'checked':'' ?>><label class="form-check-label" for="durum">Aktif</label></div></div>
    <div class="col-12"><label class="form-label">Özet</label><textarea class="form-control" name="ozet" rows="2"><?= e($h['ozet']) ?></textarea></div>
    <div class="col-12"><label class="form-label">İçerik (Uzun açıklama)</label><textarea class="form-control" name="icerik" rows="6"><?= e($h['icerik']) ?></textarea></div>
    <div class="col-md-8"><label class="form-label">Görsel</label><input type="file" class="form-control" name="gorsel_file" accept="image/*"><?php if($h['gorsel']): ?><div class="mt-2"><img src="<?= e($h['gorsel']) ?>" style="max-height:80px;border-radius:6px"></div><?php endif; ?></div>
    <div class="col-12"><button class="btn btn-primary"><i class="bi bi-save"></i> Kaydet</button> <a href="hizmetler.php" class="btn btn-outline-secondary">İptal</a></div>
  </div>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
