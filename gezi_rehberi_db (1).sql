-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Ara 2025, 22:44:49
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gezi_rehberi_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `yazar_id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `ozet` text DEFAULT NULL,
  `icerik` longtext DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `okunma_sayisi` int(11) DEFAULT 0,
  `onay_durumu` enum('onay_bekliyor','onaylandi','reddedildi') DEFAULT 'onay_bekliyor',
  `red_sebebi` varchar(255) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` enum('admin','uye') DEFAULT 'uye',
  `kayit_tarihi` datetime DEFAULT current_timestamp(),
  `ceza_puani` int(11) DEFAULT 0,
  `hesap_durumu` enum('aktif','askida') DEFAULT 'aktif',
  `dogrulama_kodu` varchar(100) DEFAULT NULL,
  `dogrulama_durumu` tinyint(1) DEFAULT 0,
  `sifirlama_kodu` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `email`, `sifre`, `rol`, `kayit_tarihi`, `ceza_puani`, `hesap_durumu`, `dogrulama_kodu`, `dogrulama_durumu`, `sifirlama_kodu`) VALUES
(2, 'ahmet', 'ahmet@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'uye', '2025-11-30 21:31:35', 0, 'askida', NULL, 1, NULL),
(3, 'admin', 'admin@gezi.com', '202cb962ac59075b964b07152d234b70', 'admin', '2025-11-30 21:34:34', 1, 'aktif', NULL, 1, NULL),
(6, 'selim', 'SelimTest3806@gmail.com', '211021d2b119d78fe0e0d4d29eeff687', 'uye', '2025-12-02 14:53:46', 0, 'aktif', '', 1, NULL),
(7, 'abc', 'Selimkose736@gmail.com', '202cb962ac59075b964b07152d234b70', 'uye', '2025-12-02 15:39:02', 0, 'aktif', 'c8491d5989df8eed5022748ba46802a5', 0, NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `kullanici_id` int(11) DEFAULT NULL,
  `islem` varchar(255) DEFAULT NULL,
  `detay` text DEFAULT NULL,
  `ip_adresi` varchar(50) DEFAULT NULL,
  `tarih` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `logs`
--

INSERT INTO `logs` (`id`, `kullanici_id`, `islem`, `detay`, `ip_adresi`, `tarih`) VALUES
(1, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-11-30 22:56:25'),
(2, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: askida', '::1', '2025-12-02 12:43:31'),
(3, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: aktif', '::1', '2025-12-02 12:43:34'),
(4, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: askida', '::1', '2025-12-02 12:43:35'),
(5, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: aktif', '::1', '2025-12-02 12:43:35'),
(6, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: askida', '::1', '2025-12-02 12:43:36'),
(7, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: aktif', '::1', '2025-12-02 12:43:37'),
(8, 3, 'Hesap Durumu Değişti', 'ID: 2, Durum: askida', '::1', '2025-12-02 13:28:42'),
(9, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 14:42:18'),
(10, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 14:45:25'),
(11, 3, 'Kullanıcı Silindi', 'Silinen ID: 4', '::1', '2025-12-02 14:45:46'),
(12, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 14:46:06'),
(13, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 14:52:54'),
(14, 3, 'Kullanıcı Silindi', 'Silinen ID: 5', '::1', '2025-12-02 14:53:22'),
(15, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 14:53:32'),
(16, 6, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 15:06:12'),
(17, 6, 'Giriş Yaptı', 'Başarılı giriş: selim', '::1', '2025-12-02 15:14:52'),
(18, 6, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 15:16:53'),
(19, 3, 'Giriş Yaptı', 'Başarılı giriş: admin', '::1', '2025-12-02 15:16:57'),
(20, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 15:23:20'),
(21, 3, 'Giriş Yaptı', 'Başarılı giriş: admin', '::1', '2025-12-02 15:23:36'),
(22, 3, 'Çıkış Yaptı', 'Oturum sonlandırıldı', '::1', '2025-12-02 15:38:32'),
(23, 3, 'Giriş Yaptı', 'Başarılı giriş: admin', '::1', '2025-12-02 16:05:07'),
(24, 3, 'Giriş Yaptı', 'Başarılı giriş: admin', '::1', '2025-12-03 00:09:15');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sehirler`
--

CREATE TABLE `sehirler` (
  `id` int(11) NOT NULL,
  `isim` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `plaka_kodu` int(2) DEFAULT 0,
  `kisa_aciklama` varchar(255) DEFAULT NULL,
  `detayli_aciklama` text DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `olusturma_tarihi` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sehirler`
--

INSERT INTO `sehirler` (`id`, `isim`, `slug`, `plaka_kodu`, `kisa_aciklama`, `detayli_aciklama`, `resim_url`, `olusturma_tarihi`) VALUES
(1, 'Ankara', 'ankara', 6, 'Türkiye\'nin başkenti ve bürokrasinin kalbi.', 'Ankara, Türkiye\'nin başkenti ve ikinci en kalabalık şehridir. Anıtkabir, Kocatepe Camii ve Atakule gibi simge yapılarıyla bilinir. Tarihi ve modern yapının iç içe geçtiği bir şehirdir.', 'https://images.unsplash.com/photo-1596394516093-501ba68a0ba6?q=80&w=2070', '2025-11-30 20:52:13'),
(2, 'İstanbul', 'istanbul', 34, 'Kıtaları birleştiren eşsiz tarih ve kültür şehri.', 'İstanbul, Asya ve Avrupa kıtalarını birbirine bağlayan, tarihi yarımadası, boğaz manzarası ve kültürel zenginliğiyle dünyanın en önemli metropollerinden biridir. Galata Kulesi, Ayasofya ve Kız Kulesi görülmesi gereken yerlerdir.', 'https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=2071', '2025-11-30 20:52:13'),
(3, 'Yozgat', 'yozgat', 66, 'Bozok yaylasının incisi, huzurlu Anadolu şehri.', 'Yozgat, İç Anadolu bölgesinde yer alan, Çamlık Milli Parkı ve Saat Kulesi ile ünlü tarihi bir şehirdir. Doğal güzellikleri ve sakin yapısıyla bilinir.', 'images/yozgat_1764529463.jpg', '2025-11-30 20:52:13'),
(4, 'Kayseri', 'kayseri', 38, 'İç Anadolu\'nun ticaret, sanayi ve lezzet başkenti.', 'Kayseri, İç Anadolu Bölgesi\'nin en önemli ticaret, sanayi ve kültür merkezlerinden biridir. Şehir, binlerce yıllık tarihi boyunca Hititler, Roma ve özellikle Selçuklu gibi birçok medeniyete ev sahipliği yapmıştır.\r\n\r\nŞehrin simgesi olan Erciyes Dağı, dört mevsim aktif bir turizm merkezidir. Anadolu\'nun ilk tıp merkezi olan Gevher Nesibe Şifahanesi gibi Selçuklu mimarisinin önemli eserlerini barındırır.\r\n\r\nPastırma, sucuk ve meşhur mantısı ile Türkiye mutfağında ayrıcalıklı bir yere sahiptir.', 'images/sehir_1764531979.jpg', '2025-11-30 22:44:28'),
(5, 'Antalya', 'antalya', 7, 'Turizmin başkenti, güneşin ve tarihin şehri.', 'Antalya, Türkiye\'nin turizm başkentidir. Düden Şelalesi, Kaleiçi, antik kentleri ve muhteşem plajlarıyla hem tarih hem de doğa severler için bir cennettir.', 'https://images.unsplash.com/photo-1542051841857-5f906991ddce?q=80&w=1000', '2025-11-30 22:48:57'),
(6, 'İzmir', 'izmir', 35, 'Ege\'nin incisi, özgürlüğün şehri.', 'İzmir, kordon boyu, sıcak insanları ve tarihi zenginlikleriyle Ege\'nin en güzel şehridir. Efes Antik Kenti ve Saat Kulesi görülmesi gereken yerlerin başındadır.', 'https://images.unsplash.com/photo-1563294338-34927762696e?q=80&w=1000', '2025-11-30 22:48:57'),
(7, 'Trabzon', 'trabzon', 61, 'Yeşilin ve mavinin buluştuğu Karadeniz şehri.', 'Trabzon, Sümela Manastırı, Uzungöl ve yaylalarıyla doğa turizminin merkezidir. Hamsi ve Akçaabat köfte gibi lezzetleriyle ünlüdür.', 'https://images.unsplash.com/photo-1572535078737-2e6466e33a23?q=80&w=1000', '2025-11-30 22:48:58'),
(8, 'Gaziantep', 'gaziantep', 27, 'Dünyanın lezzet başkenti, gastronomi şehri.', 'UNESCO koruması altındaki mutfağıyla Gaziantep, baklava, kebap ve katmerin anavatanıdır. Zeugma Mozaik Müzesi ile tarih severleri büyüler.', 'https://images.unsplash.com/photo-1636289689622-c20530776846?q=80&w=1000', '2025-11-30 22:48:58'),
(9, 'Nevşehir', 'nevsehir', 50, 'Güzel atlar diyarı Kapadokya\'nın merkezi.', 'Peri bacaları, sıcak hava balonları ve yer altı şehirleriyle masalsı bir deneyim sunan Nevşehir, Türkiye\'nin en çok turist çeken bölgelerinden biridir.', 'https://images.unsplash.com/photo-1569420803447-36cb4746d97e?q=80&w=1000', '2025-11-30 22:48:58'),
(10, 'Bursa', 'bursa', 16, 'Osmanlı\'nın ilk başkenti, Yeşil Bursa.', 'Bursa; tarihi dokusu, yeşil doğası, teleferiği ve Uludağ\'ı ile Türkiye\'nin en önemli kış turizmi ve tarih merkezlerinden biridir. UNESCO Dünya Mirası listesindeki Cumalıkızık köyü, görkemli Ulu Cami ve şifalı termal suları ile ziyaretçilerini büyüler. Aynı zamanda İskender kebabının doğduğu yerdir.', 'https://images.unsplash.com/photo-1647528097682-9602377b2437?q=80&w=1000', '2025-11-30 22:50:32');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sehir_detaylari`
--

CREATE TABLE `sehir_detaylari` (
  `id` int(11) NOT NULL,
  `sehir_id` int(11) NOT NULL,
  `baslik` varchar(100) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `aciklama` varchar(255) DEFAULT NULL,
  `resim_url` varchar(255) DEFAULT NULL,
  `harita_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sehir_detaylari`
--

INSERT INTO `sehir_detaylari` (`id`, `sehir_id`, `baslik`, `kategori`, `aciklama`, `resim_url`, `harita_url`) VALUES
(1, 1, 'Anıtkabir', 'gezi', 'Anıtlar ve Heykeller', 'images/anitkabir.jpg', 'https://www.google.com/maps/search/?api=1&query=Anıtkabir+Ankara'),
(2, 1, 'Anadolu Medeniyetleri Müzesi', 'gezi', 'Tarih Müzeleri, Arkeoloji', 'images/anadolu_medeniyetleri_muzesi.jpg', 'https://www.google.com/maps/search/?api=1&query=Anadolu+Medeniyetleri+Müzesi'),
(3, 1, 'Ankara Kalesi', 'gezi', 'Tarihi Yerler, Manzara Noktası', 'images/ankara_kalesi.jpg', 'https://www.google.com/maps/search/?api=1&query=Ankara+Kalesi'),
(4, 1, 'Kocatepe Camii', 'gezi', 'Mimari Yapılar, İbadethaneler', 'images/kocatepe_camii.jpg', 'https://www.google.com/maps/search/?api=1&query=Kocatepe+Camii+Ankara'),
(5, 1, 'Trilye Restaurant', 'restoran', 'Deniz Ürünleri, Fine Dining', 'images/trilye.jpg', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant+Ankara'),
(6, 1, '1 Arada Locanda', 'restoran', 'Uluslararası, Şık Atmosfer', 'images/1arada.jpg', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda+Ankara'),
(7, 1, 'Vento Italiano', 'restoran', 'İtalyan Mutfağı, Romantik', 'images/vento_italiano.jpg', 'https://goo.gl/maps/xyz'),
(8, 1, 'Şenol Sarı Kuaför', 'kuafor', 'Erkek Kuaförü, Saç & Sakal', 'images/senol_sari_kuafor.jpg', 'https://www.google.com/maps/search/?api=1&query=Şenol+Sarı+Kuaför+Ankara'),
(9, 1, 'Erkan Uzuner Kuaför', 'kuafor', 'Kadın Kuaförü, Kesim & Boya', 'images/erkan_uzuner_kuafor.jpg', 'https://goo.gl/maps/xyz'),
(10, 4, 'Erciyes Kayak Merkezi', 'gezi', 'Türkiye\'nin en gelişmiş kayak merkezlerinden biri. Kış turizminin yanı sıra yazın doğa yürüyüşleri için de ideal.', 'images/erciyes_kayak_merkezi.jpg', 'https://www.google.com/maps/search/Erciyes+Kayak+Merkezi'),
(11, 4, 'Kayseri Kalesi', 'gezi', 'Şehrin merkezinde yer alan tarihi kale. Roma dönemine dayanan temelleri ile Selçuklu ve Osmanlı izlerini taşır.', 'images/kayseri_kalesi.jpg', 'https://www.google.com/maps/search/Kayseri+Kalesi'),
(12, 4, 'Gevher Nesibe Şifahanesi', 'gezi', 'Anadolu\'nun ilk tıp okulu ve hastanesi kompleksi. Selçuklu mimarisinin en önemli eserlerindendir.', 'images/gevher_nesibe_sifahanesi.jpg', 'https://www.google.com/maps/search/Gevher+Nesibe+Şifahanesi'),
(13, 4, 'Soğanlı Vadisi', 'gezi', 'Kayseri sınırları içindeki Kapadokya bölümü. Kaya kiliseleri ve güvercinlikleriyle meşhur, doğa harikası bir vadi.', 'images/soganli_vadisi.jpg', 'https://www.google.com/maps/search/Soğanlı+Vadisi'),
(14, 4, 'Hacı Şükrü Mantı Evi', 'restoran', 'Kayseri\'nin en meşhur mantı restoranı. Geleneksel tariflerle hazırlanan mantının tadına bakın.', 'images/restoran_manti.jpg', 'https://www.google.com/maps/search/Hacı+Şükrü+Kayseri'),
(15, 4, 'Pastırmacı Sivaslı', 'restoran', 'Şehrin en iyi pastırma ve sucuklarını tadabileceğiniz, taze ve kaliteli et ürünleri sunan adres.', 'images/restoran_pastirma.jpg', 'https://www.google.com/maps/search/Pastırmacı+Sivaslı+Kayseri'),
(16, 4, 'Ciğerci Apo', 'restoran', 'Lezzetli ve taze ciğer, kebap ve ocakbaşı çeşitleriyle meşhur. Et severlerin vazgeçilmezi.', 'images/restoran_ocakbasi.jpg', 'https://www.google.com/maps/search/Ciğerci+Apo+Kayseri'),
(17, 4, 'Barber\'s Club', 'kuafor', 'Modern tıraş teknikleri ve saç kesimleri. Erkekler için kaliteli hizmet ve konforlu ortam.', 'images/kuaför_erkek.jpg', 'https://www.google.com/maps/search/Barber+Club+Kayseri'),
(18, 4, 'Glamour Güzellik Salonu', 'kuafor', 'Saç, makyaj ve cilt bakımı alanında profesyonel hizmetler sunan popüler kadın kuaförü.', 'images/kuaför_kadın.jpg', 'https://www.google.com/maps/search/Glamour+Güzellik+Kayseri'),
(19, 5, 'Kaleiçi', 'gezi', 'Tarihi evleri ve dar sokaklarıyla Antalya\'nın kalbi.', 'https://images.unsplash.com/photo-1589382404603-0c3099953229?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Kocatepe+Camii,+Ankara7'),
(20, 5, 'Düden Şelalesi', 'gezi', 'Denize dökülen muazzam şelale manzarası.', 'https://images.unsplash.com/photo-1596489379208-2e06a337e3c1?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Kocatepe+Camii,+Ankara8'),
(21, 5, '7 Mehmet', 'restoran', 'Akdeniz mutfağının en köklü restoranlarından biri.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Kocatepe+Camii,+Ankara9'),
(22, 6, 'Saat Kulesi', 'gezi', 'Konak meydanında bulunan şehrin simgesi.', 'https://images.unsplash.com/photo-1597384070045-365a639739a6?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara0'),
(23, 6, 'Efes Antik Kenti', 'gezi', 'Dünyanın en iyi korunmuş antik kentlerinden biri.', 'https://images.unsplash.com/photo-1563294338-34927762696e?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara1'),
(24, 6, 'Dostlar Fırını', 'restoran', 'İzmir\'in meşhur boyozunu yemek için en iyi adres.', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara2'),
(25, 7, 'Sümela Manastırı', 'gezi', 'Sarp kayalıklar üzerine kurulu tarihi manastır.', 'https://images.unsplash.com/photo-1623414902099-2777df7643b9?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara3'),
(26, 7, 'Uzungöl', 'gezi', 'Doğa harikası göl ve yayla manzarası.', 'https://images.unsplash.com/photo-1549525797-047b4d930263?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara4'),
(27, 7, 'Cemil Usta', 'restoran', 'Meşhur Akçaabat köftesinin en iyi adresi.', 'https://images.unsplash.com/photo-1529042410759-befb1204b468?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara5'),
(28, 8, 'Zeugma Mozaik Müzesi', 'gezi', 'Çingene Kızı mozaiğinin bulunduğu dünya çapında müze.', 'https://images.unsplash.com/photo-1596303977708-34927762696e?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara6'),
(29, 8, 'İmam Çağdaş', 'restoran', 'Gaziantep baklavası ve kebabının efsane adresi.', 'https://images.unsplash.com/photo-1559563362-c667ba5f5480?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara7'),
(30, 8, 'Bakırcılar Çarşısı', 'gezi', 'Tarihi el sanatlarının yaşadığı otantik çarşı.', 'https://images.unsplash.com/photo-1582298782386-b4522923971f?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara8'),
(31, 9, 'Peri Bacaları', 'gezi', 'Doğanın mucizesi eşsiz kaya oluşumları.', 'https://images.unsplash.com/photo-1641128324972-af3212f0f6bd?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=Trilye+Restaurant,+Ankara9'),
(32, 9, 'Balon Turu', 'gezi', 'Gündoğumunda Kapadokya manzarasını gökyüzünden izleyin.', 'https://images.unsplash.com/photo-1534068590799-09895a701d3e?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara0'),
(33, 9, 'Testi Kebabı', 'restoran', 'Yöresel sunumuyla meşhur testi kebabı deneyimi.', 'https://images.unsplash.com/photo-1594046243098-0fceea9d451e?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara1'),
(34, 10, 'Ulu Cami', 'gezi', 'Osmanlı mimarisinin en görkemli ve ruhani eserlerinden biri.', 'https://images.unsplash.com/photo-1628678257045-31f0c3995347?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara2'),
(35, 10, 'Uludağ Kayak Merkezi', 'gezi', 'Türkiye\'nin en popüler kış sporları ve kayak merkezi.', 'https://images.unsplash.com/photo-1612967115180-232cb97973c7?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara3'),
(36, 10, 'Cumalıkızık Köyü', 'gezi', 'Osmanlı sivil mimarisini günümüze taşıyan rengarenk tarihi köy.', 'https://images.unsplash.com/photo-1595603780362-921359c3666d?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara4'),
(37, 10, 'Tarihi İskender Kebapçısı', 'restoran', '1867\'den beri değişmeyen lezzet, gerçek İskender deneyimi.', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara5'),
(38, 10, 'Çiçek Izgara', 'restoran', 'Bursa\'nın meşhur İnegöl köftesi için en köklü adres.', 'https://images.unsplash.com/photo-1529042410759-befb1204b468?q=80&w=500', 'https://www.google.com/maps/search/?api=1&query=1+Arada+Locanda,+Ankara6'),
(39, 2, '31 mkeanı', 'restoran', 'ÇOK ÇOK DİK VAR NAM NAM', '', ''),
(40, 1, 'ASPAVA', 'restoran', 'YEMEK', 'images/mekan_7737_1764669550.jpg', 'https://share.google/OWAYGDyaJzmREtP0u');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `mekan_id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `puan` int(11) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` datetime DEFAULT current_timestamp(),
  `durum` enum('onayli','gizli') DEFAULT 'onayli'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `yorumlar`
--

INSERT INTO `yorumlar` (`id`, `mekan_id`, `uye_id`, `puan`, `yorum`, `tarih`, `durum`) VALUES
(1, 29, 3, 5, 'asşdasşhjdaşlsjdşajsdşljaşldjas', '2025-12-02 13:25:07', 'gizli'),
(2, 40, 3, 5, 'ıolyaoısydılasdlkahdlşoashj', '2025-12-02 14:30:51', 'gizli'),
(3, 36, 3, 5, 'opjfidsqa ', '2025-12-02 16:15:23', 'gizli'),
(4, 36, 3, 5, 'sadasdasds', '2025-12-02 16:58:43', 'gizli'),
(5, 36, 3, 5, 'bbasöbdas', '2025-12-02 16:59:01', 'gizli');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`),
  ADD KEY `yazar_id` (`yazar_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Tablo için indeksler `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sehirler`
--
ALTER TABLE `sehirler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `sehir_detaylari`
--
ALTER TABLE `sehir_detaylari`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sehir_id` (`sehir_id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mekan_id` (`mekan_id`),
  ADD KEY `uye_id` (`uye_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `sehirler`
--
ALTER TABLE `sehirler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `sehir_detaylari`
--
ALTER TABLE `sehir_detaylari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `blog`
--
ALTER TABLE `blog`
  ADD CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`yazar_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `sehir_detaylari`
--
ALTER TABLE `sehir_detaylari`
  ADD CONSTRAINT `sehir_detaylari_ibfk_1` FOREIGN KEY (`sehir_id`) REFERENCES `sehirler` (`id`) ON DELETE CASCADE;

--
-- Tablo kısıtlamaları `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD CONSTRAINT `yorumlar_ibfk_1` FOREIGN KEY (`mekan_id`) REFERENCES `sehir_detaylari` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `yorumlar_ibfk_2` FOREIGN KEY (`uye_id`) REFERENCES `kullanicilar` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
