<?php
$adminTitle='Referanslar';
require_once __DIR__ . '/inc/crud.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
    csrf_check();
    $id = (int)($_POST['id'] ?? 0);
    $data = [
        'ad'    => trim($_POST['ad']),
        'unvan' => trim($_POST['unvan']),
        'yorum' => trim($_POST['yorum']),
        'foto'  => adminGorselYukle('foto_file') ?: trim($_POST['foto_url']),
        'yildiz'=> (int)$_POST['yildiz'],
        'durum' => isset($_POST['durum'])?1:0,
    ];
    if($id){
        $eskiStmt = $db->prepare("SELECT foto FROM referanslar WHERE id=?");
        $eskiStmt->execute([$id]); $eski = $eskiStmt->fetch();
        if(!$data['foto']) $data['foto'] = $eski['foto'] ?? '';
        $stmt = $db->prepare("UPDATE referanslar SET ad=:ad,unvan=:unvan,yorum=:yorum,foto=:foto,yildiz=:yildiz,durum=:durum WHERE id=:id");
        $data['id']=$id; $stmt->execute($data);
        adminFlash('Referans güncellendi.');
    } else {
        $stmt = $db->prepare("INSERT INTO referanslar(ad,unvan,yorum,foto,yildiz,durum) VALUES(:ad,:unvan,:yorum,:foto,:yildiz,:durum)");
        $stmt->execute($data);
        adminFlash('Referans eklendi.');
    }
    header('Location: ' . SITE_URL . '/admin/referanslar.php'); exit;
}
if(isset($_GET['sil'])){
    $id = (int)$_GET['sil'];
    $stmt = $db->prepare("SELECT foto FROM referanslar WHERE id=?");
    $stmt->execute([$id]); $r = $stmt->fetch();
    if($r && $r['foto'] && str_starts_with($r['foto'], UPLOADS_URL.'/')){
        $yol = UPLOADS . '/' . basename($r['foto']);
        if(is_file($yol)) @unlink($yol);
    }
    $db->prepare("DELETE FROM referanslar WHERE id=?")->execute([$id]);
    adminFlash('Referans silindi.');
    header('Location: ' . SITE_URL . '/admin/referanslar.php'); exit;
}

$duzId = (int)($_GET['id'] ?? 0);
$d = ['id'=>0,'ad'=>'','unvan'=>'','yorum'=>'','foto'=>'','yildiz'=>5,'durum'=>1];
if($duzId){ $st=$db->prepare("SELECT * FROM referanslar WHERE id=?"); $st->execute([$duzId]); $d=$st->fetch()?:$d; }
$liste = $db->query("SELECT * FROM referanslar ORDER BY id DESC")->fetchAll();
$flash = adminFlashCek();
require_once __DIR__ . '/inc/header.php';
?>
<?php if($flash): ?><div class="alert alert-<?= $flash['tip']==='success'?'success':'danger' ?>"><?= e($flash['msg']) ?></div><?php endif; ?>
<div class="row g-4">
  <div class="col-lg-5">
    <form method="post" enctype="multipart/form-data" class="card p-4">
      <h5><?= $duzId?'Referans Düzenle':'Yeni Referans' ?></h5>
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <input type="hidden" name="id" value="<?= $d['id'] ?>">
      <div class="mb-2"><label class="form-label">Ad Soyad *</label><input class="form-control" name="ad" value="<?= e($d['ad']) ?>" required></div>
      <div class="mb-2"><label class="form-label">Ünvan</label><input class="form-control" name="unvan" value="<?= e($d['unvan']) ?>"></div>
      <div class="mb-2"><label class="form-label">Yorum *</label><textarea class="form-control" name="yorum" rows="4" required><?= e($d['yorum']) ?></textarea></div>
      <div class="row g-2 mb-2">
        <div class="col-6"><label class="form-label">Yıldız</label><select class="form-select" name="yildiz"><?php for($i=5;$i>=1;$i--): ?><option value="<?= $i ?>" <?= $d['yildiz']==$i?'selected':'' ?>><?= str_repeat('⭐',$i) ?></option><?php endfor; ?></select></div>
        <div class="col-6 d-flex align-items-end"><div class="form-check"><input type="checkbox" class="form-check-input" id="durum" name="durum" <?= $d['durum']?'checked':'' ?>><label class="form-check-label" for="durum">Aktif</label></div></div>
      </div>
      <div class="mb-2"><label class="form-label">Foto Yükle</label><input type="file" class="form-control" name="foto_file" accept="image/*"></div>
      <div class="mb-2"><label class="form-label">veya Foto URL</label><input class="form-control" name="foto_url" value="<?= e($d['foto']) ?>"></div>
      <?php if($d['foto']): ?><img src="<?= e($d['foto']) ?>" class="mb-2" style="width:60px;height:60px;border-radius:50%;object-fit:cover"><?php endif; ?>
      <button class="btn btn-primary"><i class="bi bi-save"></i> Kaydet</button>
      <?php if($duzId): ?> <a href="referanslar.php" class="btn btn-link">İptal</a><?php endif; ?>
    </form>
  </div>
  <div class="col-lg-7">
    <div class="card">
      <div class="card-header">Mevcut Referanslar (<?= count($liste) ?>)</div>
      <ul class="list-group list-group-flush">
        <?php foreach($liste as $r): ?>
        <li class="list-group-item d-flex align-items-center gap-3">
          <?php if($r['foto']): ?><img src="<?= e($r['foto']) ?>" style="width:50px;height:50px;border-radius:50%;object-fit:cover"><?php endif; ?>
          <div class="flex-grow-1">
            <strong><?= e($r['ad']) ?></strong> <span class="text-muted">— <?= e($r['unvan']) ?></span>
            <div><?= str_repeat('⭐',(int)$r['yildiz']) ?></div>
            <small class="text-muted"><?= e(mb_substr($r['yorum'],0,90)) ?>...</small>
          </div>
          <a href="?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
          <a href="?sil=<?= $r['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Silinsin mi?')"><i class="bi bi-trash"></i></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
