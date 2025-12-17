🌍 Gezi Rehberi - Web Tabanlı Seyahat ve Blog Platformu
Bu proje, kullanıcıların şehirleri keşfedebileceği, gezi yazılarını okuyabileceği ve kendi deneyimlerini paylaşabileceği dinamik bir web uygulamasıdır. PHP ve MySQL kullanılarak geliştirilmiştir.
![gezi1](https://github.com/user-attachments/assets/248ab47f-6b6d-406a-bd9e-086c3d52805a)
![gezi2](https://github.com/user-attachments/assets/586ce4a8-df09-4390-9701-164ebb0e00d0)
![gezi3](https://github.com/user-attachments/assets/f68be00a-ef4a-422c-99c9-4c0ad09c13cc)

📋 Proje Hakkında
Gezi Rehberi, gezginler için dijital bir kılavuz niteliğindedir. Kullanıcılar şehir detaylarına ulaşabilir, blog yazılarını inceleyebilir ve sisteme üye olarak etkileşimde bulunabilirler. Yönetici (Admin) paneli üzerinden tüm içerik ve kullanıcı hareketleri kontrol edilebilir.

🚀 Özellikler
👤 Kullanıcı Arayüzü (Front-End)
Şehir Rehberi: Türkiye'deki şehirlerin tanıtımı, gezilecek yerler ve detaylı bilgiler.

Blog Sistemi: Kullanıcıların gezi yazılarını okuyabileceği ve kendi yazılarını gönderebileceği alan.

Üyelik Sistemi: Kayıt ol, Giriş yap ve Çıkış yap fonksiyonları.

Yorum Yapma: Mekanlara ve yazılara yorum/puan bırakma özelliği.

🛡️ Yönetici Paneli (Back-End)
Dashboard: Site genel durum özeti.

İçerik Yönetimi: Blog yazılarını onaylama, reddetme veya silme.

Şehir Yönetimi: Yeni şehir ekleme, düzenleme ve silme işlemleri.

Kullanıcı Yönetimi: Üyeleri görüntüleme ve yönetme.

Log (Kayıt) Sistemi: Yöneticilerin ve kullanıcıların site üzerindeki hareketlerini (Giriş, Çıkış, Ekleme vb.) tarih ve detaylarıyla kaydeden güvenlik günlüğü.

🛠️ Kullanılan Teknolojiler
Dil: PHP (Native/Procedural)

Veritabanı: MySQL / MariaDB

Arayüz: HTML5, CSS3

Sunucu: Apache (XAMPP/WAMP önerilir)

🗄️ Veritabanı Yapısı
Proje gezi_rehberi_db adında bir veritabanı kullanır ve aşağıdaki tablolardan oluşur:

kullanicilar: Yönetici ve üyelerin hesap bilgileri.

blog: Gezi yazıları, yazar ID'si ve onay durumları (onay_bekliyor, onaylandi).

sehirler: Şehirlerin genel bilgileri ve kapak fotoğrafları.

sehir_detaylari: Şehirlere ait alt detaylar (Müzeler, parklar vb.).

yorumlar: Kullanıcı yorumları ve puanlamalar.

logs: Sistemdeki işlemlerin (Login, Logout, Insert vb.) kayıtları.

⚙️ Kurulum Adımları
Projenin yerel sunucuda (Localhost) çalıştırılması için:

Dosyaları Yükleyin: Proje dosyalarını C:/xampp/htdocs/gezi-rehberi (veya kullandığınız sunucunun kök dizinine) klasörüne kopyalayın.

Veritabanını Oluşturun:

phpMyAdmin'e gidin (http://localhost/phpmyadmin).

gezi_rehberi_db adında yeni bir veritabanı oluşturun.

Proje klasöründeki gezi_rehberi_db.sql dosyasını içe aktarın (Import edin).

Veritabanı Bağlantısı:

includes/db.php (veya baglanti.php) dosyasını açın.

Kullanıcı adı (root) ve şifre alanlarını kendi sunucu ayarlarınıza göre düzenleyin.

Çalıştırın: Tarayıcınızdan http://localhost/gezi-rehberi adresine gidin.

🔑 Varsayılan Giriş Bilgileri (Örnek)
Admin Kullanıcı Adı: admin

Şifre: 123456 (Veya veritabanında belirlediğiniz şifre)
