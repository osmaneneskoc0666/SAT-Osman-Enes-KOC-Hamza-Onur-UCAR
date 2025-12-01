<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>YOZGAT</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>        
        /* Genel Stil AyarlarÄ± */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6; /* AÃ§Ä±k gri arka plan */
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        h1{ text-align: center; }
        h2{ text-align: center; }
        h3{ text-align: center; }
        
        /* Tema Rengi: Koyu AltÄ±n SarÄ±sÄ± (Saat Kulesi ve Tarihi YapÄ± TemasÄ±) */
        :root {
            --primary-color: #228B22; /* Dark Goldenrod */
            --secondary-color: #228B22; /* Goldenrod */
        }
        
        /* 1. ÃœST MENÃœ STÄ°LLERÄ° */
        .ust-menu-alani {
            background-color: var(--primary-color); 
            color: white;
            padding: 15px 5%; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo { font-size: 24px; font-weight: bold; letter-spacing: 1px; }
        
        .menu a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            margin-left: 5px;
            border: 1px solid transparent;
            transition: all 0.3s;
            border-radius: 5px;
            display: inline-block;
        }

        .menu a i { margin-right: 5px; }

        .menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: white;
        }
        
        /* 2. ORTALANMIÅ RESÄ°M ve HÄ°ZALI METÄ°N ALANI STÄ°LLERÄ° */
        main {
            padding: 40px 20px;
            display: block;
        }
        
        .content-area {
            width: 90%; 
            max-width: 1000px; 
            margin: 0 auto 40px auto;
            padding: 20px;
            background-color: white; 
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); 
        }

        .image-wrapper {
            padding: 20px 0;
            text-align: center;
        }

        .image-wrapper img {
            width: 100%;
            height: 320px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .text-content {
            padding-top: 20px;
            font-size: 16px;
            line-height: 1.6;
            color: #333;
        }

        .text-content p {
            margin-bottom: 20px;
            text-align: justify;
        }
        
        /* 4. HIZLI ERÄ°ÅÄ°M BUTONLARI STÄ°LLERÄ° */
        .quick-links {
            margin-top: 20px; 
            padding: 5px 0;
            border-radius: 3px;
            text-align: center;
        }
        
        .quick-links h3 {
            color: var(--primary-color); 
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 2px solid #eee;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }

        .links-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap; 
            gap: 15px; 
            padding: 0 10px;
        }

        .link-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-weight: bold;
            flex-basis: calc(25% - 15px); 
            min-width: 100px; 
            padding: 15px 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white; 
            border: 1px solid #ffffff;
        }

        .link-item i {
            font-size: 28px;
            margin-bottom: 8px;
            color: var(--primary-color); 
        }
        
        .link-item span {
            font-size: 14px;
        }

        .link-item:hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        
        .link-item:hover i {
            color: white; 
        }
        
        /* 5. BLOK GRÄ°D STÄ°LLERÄ° (Gezi, Restoran, KuafÃ¶r) */
        .destinations-grid, .restoran-grid, .kuafÃ¶r-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 eÅŸit sÃ¼tun */
            gap: 20px; /* Bloklar arasÄ± boÅŸluk */
            margin-top: 20px;
            padding: 20px;
            border-top: 1px solid #eee; /* AyÄ±rÄ±cÄ± */
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        
        /* Yeni gridler iÃ§in Ã¼stten boÅŸluk */
        .restoran-grid, .kuafÃ¶r-grid {
            margin-top: 30px; 
            border-top: 1px solid #ccc;
        }

        .destination-card {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden; 
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .destination-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }
        
        /* Resim AlanÄ± Stilleri */
        .card-image {
            width: 100%;
            height: 260px; /* Resim YÃ¼ksekliÄŸi */
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
        }

        .card-content {
            padding: 10px 15px;
            text-align: left;
        }

        .card-content h4 {
            margin: 0 0 5px 0;
            font-size: 16px;
            color: #333;
        }

        /* AÃ§Ä±klama ve Butonun Yan Yana Gelmesi Ä°Ã§in Flex YapÄ± */
        .description-flex {
            display: flex;
            justify-content: space-between;
            align-items: center; /* Ã–ÄŸeleri dikeyde ortala */
            gap: 10px;
        }
        
        .description-flex p {
            margin: 0;
            font-size: 15px; 
            color: #666;
            flex-grow: 1; /* Metnin kalan alanÄ± doldurmasÄ±nÄ± saÄŸla */
        }
        
        /* BUTON STÄ°LÄ° */
        .git-button {
            background-color: var(--primary-color); 
            color: white;
            border: none;
            padding: 7px 14px; 
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 18px; 
            transition: background-color 0.3s;
            white-space: nowrap; 
        }
        
        .git-button:hover {
            background-color: var(--secondary-color); 
        }


        /* KÃ¼Ã§Ã¼k ekranlar (DuyarlÄ± TasarÄ±m) */
        @media (max-width: 768px) {
            .ust-menu-alani {
                flex-direction: column; 
                padding: 15px 20px;
            }
            .links-container {
                justify-content: center;
            }
            .link-item {
                flex-basis: calc(50% - 15px);
                margin-bottom: 10px;
            }
            .destinations-grid, .restoran-grid, .kuafÃ¶r-grid {
                grid-template-columns: 1fr; /* Tek sÃ¼tun */
                padding: 10px;
            }
        }
    </style>
</head>
<body>

    <header class="ust-menu-alani">
        <div class="logo"><img src="images/logo.png" alt="logo goruntÃ¼lenmiyor" style="width: 100px;"></div>
        <nav class="menu">
            <a href="https://www.obilet.com/otobus-bileti/yozgat" target="_blank"><i class="fas fa-bus"></i> OtobÃ¼s </a>
            <a href="https://www.trivago.com.tr/tr/s?q=otel+yozgat" target="_blank"><i class="fas fa-bed"></i> Konaklama</a>
            <a href="https://www.obilet.com/ucak-bileti/yozgat-sivas" target="_blank"><i class="fas fa-plane"></i> UÃ§uÅŸ (En YakÄ±n Sivas/Kayseri)</a>
        </nav>
    </header>

    <main>
        
        
        <div class="content-area">
            <h1 style="text-align: center;"><b>Yozgat</b></h1>
            
            <div class="image-wrapper"> 
                <img src="images/yozgat_camligi.jpg" style="width: 650px;" alt="Yozgat Ã‡amlÄ±ÄŸÄ± Milli ParkÄ± manzarasÄ±">
            </div>
            
            <div class="text-content">
                <H2><b>(66)HakkÄ±nda - Bozok YaylasÄ± ve Ã‡amlÄ±k Milli ParkÄ±</b></H2>
                <p><b>
                Ä°Ã§ Anadolu BÃ¶lgesi'nin Bozok Platosu Ã¼zerinde yer alan Yozgat, tarihi ve doÄŸal gÃ¼zellikleriyle dikkat Ã§eker. TÃ¼rkiye'nin ilk milli parkÄ± unvanÄ±na sahip olan **Yozgat Ã‡amlÄ±ÄŸÄ± Milli ParkÄ±**, ÅŸehir merkezinin yakÄ±nÄ±nda nefes alan bir doÄŸal alandÄ±r.<br>
                Yozgat, mimarisiyle Ã¶ne Ã§Ä±kan **Ã‡apanoÄŸlu Camii** ve ÅŸehrin simgesi **Saat Kulesi** gibi tarihi yapÄ±lara sahiptir. YÃ¶resel mutfaÄŸÄ± ise Testi KebabÄ±, ArabaÅŸÄ± ve MadÄ±mak gibi geleneksel Ä°Ã§ Anadolu lezzetleriyle tanÄ±nÄ±r.
                </b>
                </p>
                
                <div class="quick-links">
                    <h3>HÄ±zlÄ± EriÅŸim BaÄŸlantÄ±larÄ±</h3>
                    <div class="links-container">
                        <a href="#" class="link-item">
                            <i class="fas fa-utensils"></i>
                            <span>Restorant</span>
                        </a>
                        <a href="#" class="link-item">
                            <i class="fas fa-landmark"></i>
                            <span>Tarih/Gezi</span>
                        </a>
                        <a href="#" class="link-item">
                            <i class="fas fa-cut"></i>
                            <span>KuafÃ¶r</span>
                        </a>
                    </div>
                    
                    <h2 style="margin-top: 20px; margin-bottom: 20px; padding-top: 20px; border-bottom: 2px solid #eee;">Gezi Ve Tarih</h2>
                    
                    <div class="destinations-grid">
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/yozgat_camligi_milli.jpg" alt="Yozgat Ã‡amlÄ±ÄŸÄ± Milli ParkÄ±">
                            </div>
                            <div class="card-content">
                                <h4>Yozgat Ã‡amlÄ±ÄŸÄ± Milli ParkÄ±</h4>
                                <div class="description-flex">
                                    <p>TÃ¼rkiye'nin Ä°lk Milli ParkÄ± Olan YemyeÅŸil Alan</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M205', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/capanoglu_camii.jpg" alt="Ã‡apanoÄŸlu BÃ¼yÃ¼k Camii">
                            </div>
                            <div class="card-content">
                                <h4>Ã‡apanoÄŸlu BÃ¼yÃ¼k Camii</h4>
                                <div class="description-flex">
                                    <p>OsmanlÄ± DÃ¶nemi Mimarisinin Ã–nemli Eseri</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M206', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/yozgat_saat_kulesi.jpg" alt="Yozgat Saat Kulesi">
                            </div>
                            <div class="card-content">
                                <h4>Yozgat Saat Kulesi</h4>
                                <div class="description-flex">
                                    <p>Åehrin SembolÃ¼ Haline GelmiÅŸ Tarihi YapÄ±</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M207', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/kerkenes_harabeleri.jpg" alt="Kerkenes Harabeleri">
                            </div>
                            <div class="card-content">
                                <h4>Kerkenes Harabeleri</h4>
                                <div class="description-flex">
                                    <p>Hititler'den Sonra KurulmuÅŸ Demir Ã‡aÄŸÄ± Åehri KalÄ±ntÄ±larÄ±</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M208', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                    </div>
                    <h2 style="margin-top: 40px; margin-bottom: 20px; padding-top: 20px; border-bottom: 2px solid #eee;">PopÃ¼ler Restoran ve YÃ¶resel Lezzetler</h2>
                    
                    <div class="restoran-grid">
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/testi_kebabi_hayri.jpg" alt="Hayri Usta Testi KebabÄ±">
                            </div>
                            <div class="card-content">
                                <h4>Hayri Usta Testi KebabÄ±</h4>
                                <div class="description-flex">
                                    <p>Yozgat'Ä±n MeÅŸhur YemeÄŸi Testi KebabÄ± Ä°Ã§in Bilinen Adres</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M209', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/fuat_kebap.jpg" alt="Fuat Kebab Salonu">
                            </div>
                            <div class="card-content">
                                <h4>Fuat Kebab Salonu</h4>
                                <div class="description-flex">
                                    <p>PopÃ¼ler Kebap ve Lahmacun Ã‡eÅŸitleri Sunan Mekan</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M210', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/yozgat_sofrasi.jpg" alt="Yozgat SofrasÄ±">
                            </div>
                            <div class="card-content">
                                <h4>Yozgat SofrasÄ± (YÃ¶resel)</h4>
                                <div class="description-flex">
                                    <p>MadÄ±mak ve ArabaÅŸÄ± Gibi YÃ¶resel Yemekler</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M211', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/camlik_restaurant.jpg" alt="Ã‡amlÄ±k Restaurant">
                            </div>
                            <div class="card-content">
                                <h4>Ã‡amlÄ±k Restaurant</h4>
                                <div class="description-flex">
                                    <p>Milli Park Ä°Ã§inde DoÄŸa ManzaralÄ± Yemek Deneyimi</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M212', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                    </div>
                    <h2 style="margin-top: 40px; margin-bottom: 20px; padding-top: 20px; border-bottom: 2px solid #eee;">PopÃ¼ler KuafÃ¶r ve GÃ¼zellik SalonlarÄ±</h2>
                    
                    <div class="kuafÃ¶r-grid">
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/kuafor_erhan_yozgat.jpg" alt="KuafÃ¶r Erhan">
                            </div>
                            <div class="card-content">
                                <h4>KuafÃ¶r Erhan (Erkek)</h4>
                                <div class="description-flex">
                                    <p>Åehir Merkezinde Bilinen Erkek KuafÃ¶r Hizmetleri</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M213', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/yozgat_elit.jpg" alt="Yozgat Elit GÃ¼zellik Salonu">
                            </div>
                            <div class="card-content">
                                <h4>Yozgat Elit GÃ¼zellik Salonu (Bayan)</h4>
                                <div class="description-flex">
                                    <p>SaÃ§, Makyaj ve ManikÃ¼r Hizmetleri</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M214', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/berber_mehmet_yozgat.jpg" alt="Berber Mehmet">
                            </div>
                            <div class="card-content">
                                <h4>Berber Mehmet (Erkek)</h4>
                                <div class="description-flex">
                                    <p>Merkezde Geleneksel ve Modern Berberlik Hizmetleri</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M215', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="#" class="destination-card">
                            <div class="card-image">
                                <img src="images/gul_bayan_yozgat.jpg" alt="GÃ¼l Bayan KuafÃ¶rÃ¼">
                            </div>
                            <div class="card-content">
                                <h4>GÃ¼l Bayan KuafÃ¶rÃ¼ (Bayan)</h4>
                                <div class="description-flex">
                                    <p>PopÃ¼ler SaÃ§ TasarÄ±m ve BakÄ±m Hizmetleri</p>
                                    <button class="git-button" onclick="window.open('http://googleusercontent.com/maps.google.com/M216', '_blank')">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                    </div>
                    </div>
            </div>
        </div>
        
    </main>

</body>
</html>
