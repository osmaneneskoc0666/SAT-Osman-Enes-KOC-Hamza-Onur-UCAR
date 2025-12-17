🌍 Gezi Rehberi - Web Tabanlı Seyahat ve Blog Platformu

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

> Bu proje, üniversite bitirme ödevi kapsamında geliştirilmiş dinamik bir seyahat ve blog yönetim sistemidir.

📷 Projeden Görüntüler

🏠 Ana Sayfa ve Kullanıcı Arayüzü
Projenin karşılama ekranı ve kullanıcıların etkileşime girdiği sayfalar.

<div align="center">
  <img src="screenshots/image_2.png.jpg" alt="Gezi Rehberi Ana Sayfa" width="90%" style="margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">
  
  <br>

  <img src="screenshots/image_0.png" alt="Ankara Şehir Detay Sayfası" width="45%" style="margin-right: 10px; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">
  <img src="screenshots/image_1.png" alt="Blog Yazısı Gönder Formu" width="45%" style="margin-bottom: 20px; border: 1px solid #ddd; border-radius: 5px;">
</div>

⚙️ Yönetici (Admin) Paneli
Site içeriğinin, şehirlerin ve kullanıcıların yönetildiği kontrol merkezi.

<div align="center">
  <img src="screenshots/image_3.png" alt="Admin Paneli Dashboard ve Veri Girişi" width="90%" style="border: 1px solid #ddd; border-radius: 5px;">
</div>



📖 Proje Hakkında

Gezi Rehberi, kullanıcıların şehirleri keşfedebileceği, seyahat yazılarını okuyabileceği ve kendi deneyimlerini paylaşabileceği bir web uygulamasıdır. Klasik bir blog sitesinden farklı olarak, şehir bazlı içerik filtreleme ve yönetici onaylı içerik sistemi barındırır.


🚀 Öne Çıkan Özellikler

👤 Kullanıcı Arayüzü (Front-End)
Şehir Rehberi: Türkiye'deki şehirler için özel sayfalar, kapak fotoğrafları ve detaylı açıklamalar.
İçerik Üretimi: Kullanıcılar kendi gezi yazılarını ve kapak görsellerini sisteme yükleyebilirler.
Etkileşim: Mekanlara puan verme ve yorum yapma özelliği.
Gelişmiş Arama: Ana sayfadan şehir veya mekan adı ile arama yapabilme.

🛡️ Yönetici Paneli (Back-End)
Genel Bakış (Dashboard): Toplam şehir, mekan ve üye sayısı gibi istatistiklerin anlık takibi.
Şehir Yönetimi: Admin panelinden yeni rota (şehir/mekan) ekleme, düzenleme ve silme.
İçerik Onay Mekanizması: Kullanıcıların gönderdiği blog yazıları admin onayından geçtikten sonra yayınlanır.
Loglama (Hareket Kaydı): Yöneticilerin ve üyelerin site üzerindeki işlemleri veritabanında kayıt altına alınır.


 🗄️ Veritabanı Mimarisi

Proje `MySQL` veritabanı üzerinde ilişkisel bir yapı kullanır. Temel tablolar şunlardır:

| Tablo Adı | Açıklama |
| :--- | :--- |
| `kullanicilar` | Üye ve Admin hesap bilgileri (Rol tabanlı). |
| `blog` | Blog yazıları, yazar ID'si ve `onay_durumu` sütunu. |
| `sehirler` | Şehirlerin genel bilgileri, plaka kodu ve resim yolları. |
| `sehir_detaylari` | Bir şehre ait gezilecek yerler, restoranlar vb. |
| `logs` | Sistemdeki tüm işlemlerin kaydedildiği güvenlik tablosu. |
| `yorumlar` | Kullanıcı yorumları ve puanları. |




*Bu proje [Yozgat Bozok Üniversitesi] - [Proje Ödevi] olarak hazırlanmıştır.
