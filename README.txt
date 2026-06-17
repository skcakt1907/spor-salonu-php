============================================================
SPOR SALONU / FİTNESS MERKEZİ TEMASI — KURUMSAL WEB SİTESİ
PHP + MySQL + Bootstrap 5   (Demo marka: Fitness Merkezi Adı)
============================================================

KURULUM (yerel WAMP / canlı sunucu)
------------------------------------------------------------
1. Dosyaları sunucuya yükleyin
   - Tüm klasörü web kök dizinine kopyalayın (örn: public_html/)

2. Veritabanı oluşturun
   - cPanel / phpMyAdmin'de yeni bir DB oluşturun (örn: spor_salonu_db)
   - kurulum.sql dosyasını import edin
   - 7 tablo + örnek veriler otomatik yüklenir

3. Veritabanı bağlantı bilgilerini düzenleyin
   - inc/config.php dosyasını açın
   - DB_HOST, DB_NAME, DB_USER, DB_PASS değerlerini doldurun
   - SITE_URL değerini gerçek domaininizle değiştirin
   - Canlı sunucuda DEBUG'i false yapın
   - Alt klasörde çalışıyorsa .htaccess içindeki RewriteBase'i güncelleyin

4. uploads/ klasörüne yazma izni verin
   - chmod 755 uploads/    (Linux)

5. Admin paneline giriş yapın
   - URL: https://siteniz.com/admin/
   - Kullanıcı: admin   Şifre: admin123
   - !!! Giriş yaptıktan sonra şifrenizi MUTLAKA değiştirin !!!

------------------------------------------------------------
SEKTÖRE ÖZEL ETİKETLER
------------------------------------------------------------
Bu temada motor "kurumsal/hizmet" altyapısıdır; etiketler spor
merkezine uyarlanmıştır:
  Hizmetler  → Üyelik Paketleri (Fitness, Yoga, Yüzme, vb...)
  Projeler   → Tesisler (Fitness Salonu, Havuz, Stüdyo, Spa...)
  Blog       → Fitness Rehberi (Sağlık & Spor Yazıları)
  Teklif Al  → Deneme Üyeliği (Ücretsiz Deneme Dersi Talebi)
Admin panelindeki "Deneme Üyelikleri" bölümü talepleri listeler.

------------------------------------------------------------
DOSYA YAPISI
------------------------------------------------------------
├── index.php             Anasayfa
├── hakkimizda.php        Hakkımızda
├── hizmetler.php         Üyelik Paketleri
├── hizmet-detay.php      Tek paket sayfası (?slug=...)
├── projeler.php          Tesisler Galeri (filtreli)
├── proje-detay.php       Tek tesis sayfası (?slug=...)
├── blog.php              Fitness Rehberi listesi
├── blog-detay.php        Tek yazı (?slug=...)
├── iletisim.php          İletişim formu + harita
├── teklif.php            Deneme Üyeliği Talebi formu
│
├── inc/                  config, db, helpers, header, footer
├── admin/                Yönetim paneli (login, CRUD'lar, ayarlar)
├── css/style.css         Tema CSS (mavi/turuncu sporty palet)
├── js/main.js            Navbar scroll efekti
├── uploads/              Yüklenen görseller (PHP engelli)
└── kurulum.sql           DB şema + örnek veri

------------------------------------------------------------
TEKNİK DETAYLAR
------------------------------------------------------------
- PHP 7.4+ (önerilen 8.x), MySQL 5.7+ / MariaDB
- PDO prepared statements, CSRF token, password_hash (bcrypt)
- XSS koruması (e() htmlspecialchars)
- Bootstrap 5.3.2 + Bootstrap Icons 1.11 (CDN)
- Responsive (mobil uyumlu)

------------------------------------------------------------
RENK PALETİ
------------------------------------------------------------
Birincil  : #0ea5e9 (elektrik mavi)
Vurgu     : #f97316 (turuncu enerji)
Koyu      : #0f172a (koyu laci)
Açık      : #f8fafc (açık gri)
- css/style.css → :root değişkenlerinden değiştirebilirsiniz

------------------------------------------------------------
DESTEK / NOTLAR
------------------------------------------------------------
- Yerel test:   http://localhost/spor-salonu-php/
- Admin:        /admin/  (admin / admin123)
- DB import:    phpMyAdmin → Import → kurulum.sql

SPOR MERKEZINE ÖZEL ÖZELLIKLER:
- Üyelik Paketleri (Fitness, Yoga, Yüzme, Pilates, vb)
- Antrenman Saatleri gösterilebilir (Admin'de düzenle)
- Sertifikalı Antrenörler tanıtım
- Tesis fotoğrafları galeri (Havuz, Salon, Stüdyo, Spa, vb)
- Deneme Üyeliği talepleri (Ücretsiz Deneme Dersi)
- Üye Başarı Hikayeleri (Referans Bölümü)
- Fitness Rehberi Blog (Diyet, Egzersiz, Sağlık yazıları)

İyi çalışmalar!
