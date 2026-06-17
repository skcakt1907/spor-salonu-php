<?php
require_once __DIR__ . '/inc/crud.php';
$id = (int)($_GET['id'] ?? 0);
$p = ['id'=>0,'baslik'=>'','slug'=>'','kategori'=>'','gorsel'=>'','aciklama'=>'','tarih'=>date('Y'),'sira'=>0,'durum'=>1];
if($id){ $stmt = $db->prepare("SELECT * FROM projeler WHERE id=?"); $stmt->execute([$id]); $p = $stmt->fetch() ?: $p; }

if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check();
    $data = [
        'baslik'  => trim($_POST['baslik']),
        'slug'    => slugify($_POST['slug'] ?: $_POST['baslik']),
        'kategori'=> trim($_POST['kategori']),
        'gorsel'  => adminGorselYukle('gorsel_file', $p['gorsel']) ?: trim($_POST['gorsel_url'] ?? $p['gorsel']),
        'aciklama'=> trim($_POST['aciklama']),
        'tarih'   => trim($_POST['tarih']),
        'sira'    => (int)$_POST['sira'],
        'durum'   => isset($_POST['durum'])?1:0,
    ];
    if($id){
        $stmt = $db->prepare("UPDATE projeler SET baslik=:baslik,slug=:slug,kategori=:kategori,gorsel=:gorsel,aciklama=:aciklama,tarih=:tarih,sira=:sira,durum=:durum WHERE id=:id");
        $data['id']=$id; $stmt->execute($data);
        adminFlash('Proje güncellendi.');
    } else {
        $stmt = $db->prepare("INSERT INTO projeler(baslik,slug,kategori,gorsel,aciklama,tarih,sira,durum) VALUES(:baslik,:slug,:kategori,:gorsel,:aciklama,:tarih,:sira,:durum)");
        $stmt->execute($data);
        adminFlash('Proje eklendi.');
    }
    header('Location: ' . SITE_URL . '/admin/projeler.php'); exit;
}
$adminTitle = $id ? 'Proje Düzenle' : 'Yeni Proje';
require_once __DIR__ . '/inc/header.php';
?>
<form method="post" enctype="multipart/form-data" class="card p-4">
  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
  <div class="row g-3">
    <div class="col-md-8"><label class="form-label">Başlık *</label><input class="form-control" name="baslik" value="<?= e($p['baslik']) ?>" required></div>
    <div class="col-md-4"><label class="form-label">Slug</label><input class="form-control" name="slug" value="<?= e($p['slug']) ?>"></div>
    <div class="col-md-4"><label class="form-label">Kategori</label><input class="form-control" name="kategori" value="<?= e($p['kategori']) ?>" placeholder="Kategori A / Kategori B"></div>
    <div class="col-md-3"><label class="form-label">Tarih (yıl)</label><input class="form-control" name="tarih" value="<?= e($p['tarih']) ?>"></div>
    <div class="col-md-2"><label class="form-label">Sıra</label><input type="number" class="form-control" name="sira" value="<?= (int)$p['sira'] ?>"></div>
    <div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" class="form-check-input" id="durum" name="durum" <?= $p['durum']?'checked':'' ?>><label class="form-check-label" for="durum">Aktif</label></div></div>
    <div class="col-12"><label class="form-label">Açıklama</label><textarea class="form-control" name="aciklama" rows="4"><?= e($p['aciklama']) ?></textarea></div>
    <div class="col-md-6"><label class="form-label">Görsel Yükle</label><input type="file" class="form-control" name="gorsel_file" accept="image/*"></div>
    <div class="col-md-6"><label class="form-label">veya Görsel URL</label><input class="form-control" name="gorsel_url" value="<?= e($p['gorsel']) ?>"></div>
    <?php if($p['gorsel']): ?><div class="col-12"><img src="<?= e($p['gorsel']) ?>" style="max-height:140px;border-radius:8px"></div><?php endif; ?>
    <div class="col-12"><button class="btn btn-primary"><i class="bi bi-save"></i> Kaydet</button> <a href="projeler.php" class="btn btn-outline-secondary">İptal</a></div>
  </div>
</form>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
