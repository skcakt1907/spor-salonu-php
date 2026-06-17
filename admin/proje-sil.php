<?php
require_once __DIR__ . '/inc/auth.php';
require_once __DIR__ . '/inc/crud.php';
$id = (int)($_GET['id'] ?? 0);
if($id){
    $stmt = $db->prepare("SELECT gorsel FROM projeler WHERE id=?");
    $stmt->execute([$id]); $r = $stmt->fetch();
    if($r && $r['gorsel'] && str_starts_with($r['gorsel'], UPLOADS_URL.'/')){
        $yol = UPLOADS . '/' . basename($r['gorsel']);
        if(is_file($yol)) @unlink($yol);
    }
    $db->prepare("DELETE FROM projeler WHERE id=?")->execute([$id]);
    adminFlash('Proje silindi.');
}
header('Location: ' . SITE_URL . '/admin/projeler.php');
