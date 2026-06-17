<?php
require_once __DIR__ . '/inc/crud.php';
$id = (int)($_GET['id'] ?? 0);
$b = ['id'=>0,'baslik'=>'','slug'=>'','kategori'=>'','ozet'=>'','icerik'=>'','gorsel'=>'','tarih'=>date('Y-m-d'),'durum'=>1];
if($id){ $stmt = $db->prepare("SELECT * FROM blog WHERE id=?"); $stmt->execute([$id]); $b = $stmt->fetch() ?: $b; }

if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check();
    $data = [
        'baslik'  => trim($_POST['baslik']),
        'slug'    => slugify($_POST['slug'] ?: $_POST['baslik']),
        'kategori'=> trim($_POST['kategori']),
        'ozet'    => trim($_POST['ozet']),
        'icerik'  => $_POST['icerik'],
        'gorsel'  => adminGorselYukle('gorsel_file', $b['gorsel']) ?: trim($_POST['gorsel_url'] ?? $b['gorsel']),
        'tarih'   => $_POST['tarih'] ?: date('Y-m-d'),
        'durum'   => isset($_POST['durum'])?1:0,
    ];
    if($id){
        $stmt = $db->prepare("UPDATE blog SET baslik=:baslik,slug=:slug,kategori=:kategori,ozet=:ozet,icerik=:icerik,gorsel=:gorsel,tarih=:tarih,durum=:durum WHERE id=:id");
        $data['id']=$id; $stmt->execute($data);
        adminFlash('Yazı güncellendi.');
    } else {
        $stmt = $db->prepare("INSERT INTO blog(baslik,slug,kategori,ozet,icerik,gorsel,tarih,durum) VALUES(:baslik,:slug,:kategori,:ozet,:icerik,:gorsel,:tarih,:durum)");
        $stmt->execute($data);
        adminFlash('Yazı eklendi.');
    }
    header('Location: ' . SITE_URL . '/admin/blog.php'); exit;
}
$adminTitle = $id ? 'Yazı Düzenle' : 'Yeni Yazı';
require_once __DIR__ . '/inc/header.php';
?>
<form method="post" enctype="multipart/form-data" class="card p-4">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label">Başlık *</label><input class="form-control" name="baslik" value="<?= e($b['baslik']) ?>" required></div>
    <div class="col-md-4"><label class="form-label">Slug</label><input class="form-control" name="slug" value="<?= e($b['slug']) ?>"></div>
    <div class="col-md-4"><label class="form-label">Kategori</label><input class="form-control" name="kategori" value="<?= e($b['kategori']) ?>"></div>
    <div class="col-md-3"><label class="form-label">Tarih</label><input type="date" class="form-control" name="tarih" value="<?= e($b['tarih']) ?>"></div>
    <div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" class="form-check-input" id="durum" name="durum" <?= $b['durum']?'checked':'' ?>><label class="form-check-label" for="durum">Yayında</label></div></div>
    <div class="col-12"><label class="form-label">Özet</label><textarea class="form-control" name="ozet" rows="2"><?= e($b['ozet']) ?></textarea></div>
    <div class="col-12"><label class="form-label">İçerik</label><textarea class="form-control" name="icerik" rows="10"><?= e($b['icerik']) ?></textarea></div>
    <div class="col-md-6"><label class="form-label">Görsel Yükle</label><input type="file" class="form-control" name="gorsel_file" accept="image/*"></div>
    <div class="col-md-6"><label class="form-label">veya Görsel URL</label><input class="form-control" name="gorsel_url" value="<?= e($b['gorsel']) ?>"></div>
    <?php if($b['gorsel']): ?><div class="col-12"><img src="<?= e($b['gorsel']) ?>" style="max-height:140px;border-radius:8px"></div><?php endif; ?>
    <div class="col-12"><button class="btn btn-primary"><i class="bi bi-save"></i> Kaydet</button> <a href="blog.php" class="btn btn-outline-secondary">İptal</a></div>
  </div>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
