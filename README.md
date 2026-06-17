# Tema Master — Web Office Satılabilir Tema Fabrikası

PHP + MySQL + Bootstrap 5 ile kurumsal/hizmet sektörleri için hazır web sitesi temaları üretme sistemi.

**Amaç:** web-ofisi.com benzeri hızlı tema üretimi. Her müşteri için sıfırdan yazmak yerine, sektöre uyarlanmış şablonlar sunmak.

## 📋 Üretilen Temalar

| Tema | Klasör | Renk | Database | Durum |
|------|--------|------|----------|-------|
| **Master (Jenerik Kurumsal)** | `master/` | Gri/Mavi | `tema_master` | ✅ |
| **Avukat / Hukuk Bürosu** | `avukat-php/` | Lacivert #1e3a5f | `avukat_db` | ✅ |
| **Medikal / Klinik** | `medikal-php/` | Mavi #0ea5e9 | `medikal_db` | ✅ |
| **Restoran / Kafe** | `restoran-php/` | Kırmızı #c0392b | `restoran_db` | ✅ |
| **Kuaför / Güzellik** | `kuafor-php/` | Pembe #d63384 | `kuafor_db` | ✅ |
| **Muhasebe / Mali Müşavirlik** | `muhasebe-php/` | Petrol Yeşili #0f766e | `muhasebe_db` | ✅ |

## 🚀 Hızlı Başlangıç

```bash
# 1. Klasörü sunucuya kopyala
cp -r tema-master-php/ /path/to/webroot/

# 2. Veritabanı oluştur & SQL import et
# phpMyAdmin: Yeni DB → kurulum.sql import

# 3. Konfigürasyonu güncelle
# inc/config.php: DB_NAME, DB_USER, SITE_URL

# 4. Yerel test
http://localhost/tema-master-php/
http://localhost/tema-master-php/admin/  (admin / admin123)
```

## 📐 Mimari

```
Tema Master (Jenerik Kurumsal)
↓
[Kopyala + Renk + İçerik Uyarla]
↓
Sektör Temaları (Avukat, Medikal, Restoran, vb...)
```

### Her Temada
- **Sayfalar:** index, hakkımızda, hizmetler+detay, projeler+detay, blog+detay, iletişim, teklif
- **Admin:** CRUD (hizmetler, projeler, blog, teklifler), ayarlar, mesajlar
- **Tablolar:** ayarlar, hizmetler, projeler, blog, referanslar, mesajlar, teklifler
- **Güvenlik:** PDO prepared, password_hash, CSRF, XSS koruma
- **Renkler:** CSS `:root` değişkenleri (kolay tema değişimi)

## 🎨 Renk Değiştirme

Her tema `css/style.css` dosyasında `:root` değişkenlerine sahip:

```css
:root {
  --primary: #d63384;     /* Ana renk */
  --accent: #6f42c1;      /* Vurgu */
  --dark: #1f1320;        /* Koyu zemin */
  --light: #fdf2f8;       /* Açık zemin */
}
```

## 📋 Teknik Özellikler

- **PHP:** 7.4+ (önerilen 8.x)
- **Database:** MySQL 5.7+ / MariaDB
- **Frontend:** Bootstrap 5.3 + Bootstrap Icons
- **İçerik:** Responsive, mobil uyumlu
- **Hosting:** Paylaşımlı hosting (Laravel değil, düz PHP)

## 🔄 Workflow

1. Master temadan kopyala
2. Klasör adını sektöre uyarla
3. `inc/config.php`: DB adı, SITE_URL değiştir
4. `kurulum.sql` import et
5. `css/style.css`: `:root` renkleri özelleştir
6. İçerik placeholder'ları gerçek verilerle doldur
7. `.htaccess` RewriteBase'i kontrol et
8. Admin şifresini değiştir (`/admin/`)

## 📁 Dosya Yapısı

```
tema-master-php/
├── index.php              # Anasayfa
├── hakkimizda.php        # Hakkımızda
├── hizmetler.php         # Hizmet listesi
├── projeler.php          # Galeri
├── blog.php              # Blog
├── iletisim.php          # İletişim formu
├── teklif.php            # Teklif/Randevu formu
├── admin/                # Yönetim paneli
├── inc/                  # Konfigürasyon & helpers
├── css/style.css         # Tema CSS (renk değişkenleri)
├── js/main.js            # Navbar scroll efekti
├── img/                  # Logolar & görseller
├── uploads/              # Yüklenen görseller (PHP disabled)
├── kurulum.sql           # DB şema + seed verisi
├── .htaccess             # URL rewrite
└── README.txt            # Kurulum rehberi

avukat-php/              # Avukat temas
kuafor-php/              # Kuaför temas
medikal-php/             # Medikal temas
restoran-php/            # Restoran temas
muhasebe-php/            # Muhasebe temas
```

## 🛠️ Admin Paneli

- **URL:** `/admin/`
- **Varsayılan Kullanıcı:** `admin`
- **Varsayılan Şifre:** `admin123`
- **⚠️ GÜVENLİK:** İlk giriş sonrası şifrenizi değiştirin!

### Admin Menüsü
- Dashboard
- Hizmetler (CRUD)
- Projeler/Galeri (CRUD)
- Blog (CRUD)
- Referanslar (CRUD)
- Mesajlar (Form gönderileri)
- Teklifler/Randevular (Status takibi)
- Ayarlar (Site adı, açıklama, sosyal ağlar)

## 🚨 Güvenlik Kontrol Listesi

- [ ] Admin şifresi değiştirildi
- [ ] `uploads/.htaccess` (PHP execution kapalı)
- [ ] `inc/config.php` canlı sunucuda güvenli (permissions 600)
- [ ] Database şifresi güçlü
- [ ] HTTPS etkinleştirildi (canlıda)
- [ ] `.htaccess` RewriteBase doğru

## 📝 Lisans

Dahili kullanım için. Müşteri satışı yapılmadan önce telif hakları gözden geçirilsin.

---

**Son Güncelleme:** 2026-06-15  
**Temalar:** 5 aktif + 1 master
