<?php
$adminTitle='Fiyat Teklifleri';
require_once __DIR__ . '/inc/crud.php';

if(isset($_GET['sil'])){
    $db->prepare("DELETE FROM teklifler WHERE id=?")->execute([(int)$_GET['sil']]);
    adminFlash('Teklif silindi.');
    header('Location: ' . SITE_URL . '/admin/teklifler.php'); exit;
}
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['id'])){
    csrf_check();
    $stmt = $db->prepare("UPDATE teklifler SET durum=?, notlar=? WHERE id=?");
    $stmt->execute([$_POST['durum'], $_POST['notlar'], (int)$_POST['id']]);
    adminFlash('Teklif güncellendi.');
    header('Location: ' . SITE_URL . '/admin/teklifler.php?id=' . (int)$_POST['id']); exit;
}

$detayId = (int)($_GET['id'] ?? 0);
$detay = null;
if($detayId){
    $stmt = $db->prepare("SELECT * FROM teklifler WHERE id=?"); $stmt->execute([$detayId]);
    $detay = $stmt->fetch();
}
$durumFiltre = $_GET['durum'] ?? '';
$sql = "SELECT * FROM teklifler" . ($durumFiltre ? " WHERE durum=" . $db->quote($durumFiltre) : "") . " ORDER BY tarih DESC";
$liste = $db->query($sql)->fetchAll();
$flash = adminFlashCek();

$durumlar = [
  'yeni' => ['Yeni','bg-warning text-dark'],
  'degerlendiriliyor' => ['Değerlendiriliyor','bg-info text-dark'],
  'teklif_verildi' => ['Teklif Verildi','bg-primary'],
  'kazanildi' => ['Kazanıldı','bg-success'],
  'kaybedildi' => ['Kaybedildi','bg-secondary'],
];
require_once __DIR__ . '/inc/header.php';
?>
<?php if($flash): ?><div class="alert alert-success"><?= e($flash['msg']) ?></div><?php endif; ?>

<?php if($detay): ?>
<div class="card mb-4">
  <div class="card-header d-flex justify-content-between">
    <div><i class="bi bi-clipboard-check me-2" style="color:var(--primary)"></i><strong>Teklif #<?= $detay['id'] ?></strong> — <?= e($detay['ad']) ?></div>
    <small class="text-muted"><?= date('d.m.Y H:i', strtotime($detay['tarih'])) ?></small>
  </div>
  <div class="card-body">
    <div class="row g-3 mb-3">
      <div class="col-md-3"><small class="text-muted">Telefon</small><div><a href="tel:<?= e($detay['tel']) ?>"><?= e($detay['tel']) ?></a></div></div>
      <div class="col-md-3"><small class="text-muted">E-posta</small><div><?= $detay['mail']?'<a href="mailto:'.e($detay['mail']).'">'.e($detay['mail']).'</a>':'—' ?></div></div>
      <div class="col-md-3"><small class="text-muted">Hizmet</small><div><strong><?= e($detay['hizmet']) ?></strong></div></div>
      <div class="col-md-3"><small class="text-muted">İl/İlçe</small><div><?= e($detay['il'])?:'—' ?></div></div>
      <div class="col-md-3"><small class="text-muted">Adres</small><div><?= e($detay['adres'])?:'—' ?></div></div>
      <div class="col-md-3"><small class="text-muted">Alan (m²)</small><div><?= e($detay['alan'])?:'—' ?></div></div>
      <div class="col-md-3"><small class="text-muted">Bütçe</small><div><?= e($detay['butce'])?:'—' ?></div></div>
      <div class="col-md-3"><small class="text-muted">Başlangıç</small><div><?= e($detay['baslangic'])?:'—' ?></div></div>
      <div class="col-12"><small class="text-muted">Proje Detayı</small><div style="white-space:pre-wrap;background:#f9fafb;padding:.8rem;border-radius:6px"><?= e($detay['detay'])?:'—' ?></div></div>
    </div>
    <hr>
    <form method="post" class="row g-3 align-items-end">
      <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
      <input type="hidden" name="id" value="<?= $detay['id'] ?>">
      <div class="col-md-4">
        <label class="form-label">Durum</label>
        <select class="form-select" name="durum">
          <?php foreach($durumlar as $k=>$v): ?>
            <option value="<?= $k ?>" <?= $detay['durum']===$k?'selected':'' ?>><?= $v[0] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">Notlarınız (dahili)</label><input class="form-control" name="notlar" value="<?= e($detay['notlar']) ?>"></div>
      <div class="col-md-2"><button class="btn btn-primary w-100"><i class="bi bi-save"></i> Kaydet</button></div>
    </form>
    <div class="mt-3">
      <a href="tel:<?= e($detay['tel']) ?>" class="btn btn-success btn-sm"><i class="bi bi-telephone"></i> Ara</a>
      <?php if($detay['mail']): ?><a href="mailto:<?= e($detay['mail']) ?>" class="btn btn-primary btn-sm"><i class="bi bi-envelope"></i> E-posta Gönder</a><?php endif; ?>
      <a href="?sil=<?= $detay['id'] ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Silinsin mi?')"><i class="bi bi-trash"></i> Sil</a>
      <a href="teklifler.php" class="btn btn-link btn-sm">← Listeye dön</a>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div><i class="bi bi-clipboard-check me-2"></i>Tüm Teklifler (<?= count($liste) ?>)</div>
    <div class="btn-group btn-group-sm">
      <a href="teklifler.php" class="btn <?= !$durumFiltre?'btn-primary':'btn-outline-secondary' ?>">Tümü</a>
      <?php foreach($durumlar as $k=>$v): ?>
        <a href="?durum=<?= $k ?>" class="btn <?= $durumFiltre===$k?'btn-primary':'btn-outline-secondary' ?>"><?= $v[0] ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
      <thead><tr><th>#</th><th>Ad</th><th>Telefon</th><th>Hizmet</th><th>Bütçe</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
      <tbody>
      <?php foreach($liste as $t): $du=$durumlar[$t['durum']]??['—','bg-light text-dark']; ?>
        <tr>
          <td>#<?= $t['id'] ?></td>
          <td><strong><?= e($t['ad']) ?></strong></td>
          <td><a href="tel:<?= e($t['tel']) ?>"><?= e($t['tel']) ?></a></td>
          <td><?= e($t['hizmet']) ?></td>
          <td><?= e($t['butce'])?:'—' ?></td>
          <td><span class="badge <?= $du[1] ?>"><?= $du[0] ?></span></td>
          <td><small><?= date('d.m.Y H:i', strtotime($t['tarih'])) ?></small></td>
          <td>
            <a href="?id=<?= $t['id'] ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
            <a href="?sil=<?= $t['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Silinsin mi?')"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($liste)): ?><tr><td colspan="8" class="text-center text-muted py-4">Henüz teklif yok.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
