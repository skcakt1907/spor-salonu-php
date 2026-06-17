<?php
require_once __DIR__ . '/../inc/helpers.php';
if(!empty($_SESSION['admin_id'])){ header('Location: ' . SITE_URL . '/admin/dashboard.php'); exit; }

// Brute-force koruma: 5 başarısız denemeden sonra 15 dakika kilit
$_SESSION['login_attempts']  = $_SESSION['login_attempts']  ?? 0;
$_SESSION['login_locked_at'] = $_SESSION['login_locked_at'] ?? 0;
$kilitliKalan = 0;
if($_SESSION['login_locked_at'] > 0){
    $kilitliKalan = 900 - (time() - $_SESSION['login_locked_at']);
    if($kilitliKalan <= 0){
        $_SESSION['login_attempts']  = 0;
        $_SESSION['login_locked_at'] = 0;
        $kilitliKalan = 0;
    }
}

$hata = '';
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    csrf_check();
    if($kilitliKalan > 0){
        $hata = 'Çok fazla başarısız deneme. ' . ceil($kilitliKalan/60) . ' dakika sonra tekrar deneyin.';
    } else {
        $k = trim($_POST['kullanici'] ?? '');
        $s = $_POST['sifre'] ?? '';
        $stmt = $db->prepare("SELECT * FROM admin WHERE kullanici=? LIMIT 1");
        $stmt->execute([$k]);
        $a = $stmt->fetch();
        if($a && password_verify($s, $a['sifre_hash'])){
            // Session fixation koruması — yeni session ID
            session_regenerate_id(true);
            $_SESSION['admin_id'] = $a['id'];
            $_SESSION['admin_ad'] = $a['ad_soyad'];
            $_SESSION['login_attempts']  = 0;
            $_SESSION['login_locked_at'] = 0;
            header('Location: ' . SITE_URL . '/admin/dashboard.php'); exit;
        }
        $_SESSION['login_attempts']++;
        if($_SESSION['login_attempts'] >= 5){
            $_SESSION['login_locked_at'] = time();
            $hata = 'Çok fazla başarısız deneme. 15 dakika kilitlendi.';
        } else {
            $kalan = 5 - $_SESSION['login_attempts'];
            $hata = "Kullanıcı adı veya şifre hatalı. ({$kalan} hak kaldı)";
        }
        sleep(1);
    }
}
?>
<!doctype html>
<html lang="tr"><head>
<meta charset="utf-8"><title>Admin Giriş — <?= e(ayar('site_adi')) ?></title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.css" rel="stylesheet">
<style>
body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#1f2937,#111827);min-height:100vh;display:flex;align-items:center;justify-content:center;margin:0}
.login-card{background:#fff;border-radius:16px;padding:2.5rem;width:100%;max-width:420px;box-shadow:0 20px 60px rgba(0,0,0,.3)}
.login-card .logo{text-align:center;margin-bottom:1.6rem}
.login-card .logo i{font-size:2.6rem;color:#ea7c1c}
.login-card h2{text-align:center;color:#1f2937;font-weight:700;margin-bottom:.4rem}
.login-card p{text-align:center;color:#6b7280;margin-bottom:1.8rem;font-size:.9rem}
.form-control{padding:.85rem 1rem;border-radius:8px;border:1px solid #e5e7eb}
.form-control:focus{border-color:#ea7c1c;box-shadow:0 0 0 .2rem rgba(234,124,28,.15)}
.btn-primary{background:#ea7c1c;border:none;padding:.85rem;border-radius:8px;font-weight:600;width:100%}
.btn-primary:hover{background:#c66514}
.form-label{font-weight:600;color:#1f2937;font-size:.9rem}
</style></head><body>
<div class="login-card">
  <div class="logo"><img src="<?= SITE_URL ?>/img/logo.jpg" alt="<?= e(ayar('site_adi')) ?>" style="max-height:120px;border-radius:8px"></div>
  <p style="margin-top:1rem">Yönetim Paneli Girişi</p>
  <?php if($hata): ?><div class="alert alert-danger"><?= e($hata) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
    <div class="mb-3"><label class="form-label">Kullanıcı Adı</label><input class="form-control" name="kullanici" required autofocus></div>
    <div class="mb-3"><label class="form-label">Şifre</label><input class="form-control" type="password" name="sifre" required></div>
    <button class="btn btn-primary"><i class="bi bi-box-arrow-in-right"></i> Giriş Yap</button>
  </form>
</div>
</body></html>
