<?php $adminTitle='Dashboard'; require_once __DIR__ . '/inc/header.php';
$sayilar = [
  'hizmet'    => (int)$db->query("SELECT COUNT(*) FROM hizmetler")->fetchColumn(),
  'proje'     => (int)$db->query("SELECT COUNT(*) FROM projeler")->fetchColumn(),
  'blog'      => (int)$db->query("SELECT COUNT(*) FROM blog")->fetchColumn(),
  'referans'  => (int)$db->query("SELECT COUNT(*) FROM referanslar")->fetchColumn(),
  'mesaj'     => (int)$db->query("SELECT COUNT(*) FROM mesajlar")->fetchColumn(),
  'yeniMesaj' => (int)$db->query("SELECT COUNT(*) FROM mesajlar WHERE okundu=0")->fetchColumn(),
];
$sonMesaj = $db->query("SELECT * FROM mesajlar ORDER BY tarih DESC LIMIT 5")->fetchAll();
?>
<div class="row g-3 mb-4">
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon"><i class="bi bi-tools"></i></div><div><h3><?= $sayilar['hizmet'] ?></h3><p>Hizmet</p></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon"><i class="bi bi-building"></i></div><div><h3><?= $sayilar['proje'] ?></h3><p>Proje</p></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon"><i class="bi bi-newspaper"></i></div><div><h3><?= $sayilar['blog'] ?></h3><p>Blog</p></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon"><i class="bi bi-chat-quote"></i></div><div><h3><?= $sayilar['referans'] ?></h3><p>Referans</p></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon"><i class="bi bi-envelope"></i></div><div><h3><?= $sayilar['mesaj'] ?></h3><p>Toplam Mesaj</p></div></div></div>
  <div class="col-md-4 col-lg-2"><div class="stat-card"><div class="icon" style="background:rgba(245,184,0,.15);color:#f5b800"><i class="bi bi-envelope-exclamation"></i></div><div><h3><?= $sayilar['yeniMesaj'] ?></h3><p>Okunmamış</p></div></div></div>
</div>

<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    Son Mesajlar
    <a href="mesajlar.php" class="btn btn-sm btn-primary">Tümü</a>
  </div>
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead><tr><th>Ad</th><th>E-posta</th><th>Konu</th><th>Tarih</th><th>Durum</th><th></th></tr></thead>
      <tbody>
      <?php foreach($sonMesaj as $m): ?>
        <tr>
          <td><?= e($m['ad']) ?></td>
          <td><?= e($m['mail']) ?></td>
          <td><?= e($m['konu']) ?></td>
          <td><?= date('d.m.Y H:i', strtotime($m['tarih'])) ?></td>
          <td><?php if($m['okundu']): ?><span class="badge bg-success">Okundu</span><?php else: ?><span class="badge bg-warning text-dark">Yeni</span><?php endif; ?></td>
          <td><a href="mesajlar.php?id=<?= $m['id'] ?>" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a></td>
        </tr>
      <?php endforeach; ?>
      <?php if(empty($sonMesaj)): ?><tr><td colspan="6" class="text-center text-muted py-4">Henüz mesaj yok.</td></tr><?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once __DIR__ . '/inc/footer.php'; ?>
