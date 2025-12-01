<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAYSERÄ° | Åehir Rehberi</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style> Â  Â  Â  Â 
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4 { text-align: center; color: #333; }
        
        .ust-menu-alani {
            background-color: #6c757d;
            color: white;
            padding: 10px 5%; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo { font-size: 20px; font-weight: bold; }
        
        .menu a {
            color: white;
            text-decoration: none;
            padding: 8px 12px;
            margin-left: 10px;
            transition: background-color 0.3s, transform 0.2s;
            border-radius: 4px;
        }

        .menu a:hover {
            background-color: #495057; 
            transform: translateY(-1px);
        }
        
        main { padding: 30px 20px; }
        
        .content-area {
            width: 95%; 
            max-width: 1100px; 
            margin: 0 auto;
            padding: 25px;
            background-color: white; 
            border-radius: 12px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1); 
        }

        .image-wrapper { text-align: center; margin: 20px 0; }
        
        .image-wrapper img {
            width: 100%;
            max-height: 400px;
            display: block;
            margin: 0 auto;
            border-radius: 8px;
            object-fit: cover;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .text-content {
            padding: 20px 0;
            line-height: 1.7;
            color: #444;
        }

        .text-content p { text-align: justify; margin-bottom: 15px; }
        
        .quick-links h3 {
            color: #6c757d; 
            margin-bottom: 25px;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 10px;
        }

        .links-container {
            display: flex;
            justify-content: space-evenly;
            flex-wrap: wrap; 
            gap: 20px; 
            margin-bottom: 30px;
        }

        .link-item {
            text-decoration: none;
            color: #6c757d;
            font-weight: 600;
            width: 120px;
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            background-color: #f8f9fa;
        }

        .link-item i {
            font-size: 32px;
            margin-bottom: 10px;
            color: #6c757d; 
        }
        
        .link-item:hover {
            background-color: #6c757d;
            color: white;
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        
        .link-item:hover i { color: white; }

        .grid-title {
            color: #495057;
            margin-top: 40px; 
            margin-bottom: 25px; 
            padding-top: 20px; 
            border-bottom: 2px solid #e9ecef;
        }

        .destinations-grid, .restoran-grid, .kuafÃ¶r-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            padding: 0 0 30px 0;
        }

        .card-item {
            display: flex;
            flex-direction: column;
            text-decoration: none;
            color: #333;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .card-image {
            height: 180px; 
            overflow: hidden;
        }

        .card-image img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            transition: transform 0.4s;
        }

        .card-item:hover .card-image img { transform: scale(1.05); }

        .card-content {
            padding: 15px 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            text-align: left;
        }
        
        .card-content h4 {
            color: #6c757d;
            margin-top: 0;
            font-size: 18px;
            text-align: left;
        }

        .card-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .card-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .git-button {
            background-color: #6c757d; 
            color: white;
            border: none;
            padding: 8px 16px; 
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            font-size: 14px; 
            transition: background-color 0.3s;
            white-space: nowrap; 
        }
        
        .git-button:hover { background-color: #495057; }

        @media (max-width: 768px) {
            .ust-menu-alani {
                flex-direction: column; 
                padding: 15px 20px;
            }
            .menu a { margin: 5px; }
            .links-container { justify-content: center; }
            .link-item { flex-basis: 40%; min-width: 140px; }
        }
    </style>
</head>
<body>

    <header class="ust-menu-alani">
        <div class="logo"><img src="images/logo.png" alt="logo goruntÃ¼lenmiyor" style="width: 100px;"></div>
        <nav class="menu">
            <a href="https://www.obilet.com/otobus-bileti/kayseri" target="_blank"><i class="fas fa-map-marked-alt"></i> OtobÃ¼s </a>
            <a href="https://www.trivago.com.tr/tr/s?q=otel+kayseri" target="_blank"><i class="fas fa-bed"></i> Konaklama</a>
            <a href="https://www.obilet.com/ucak-bileti/kayseri" target="_blank"><i class="fas fa-plane"></i> Transfer</a>
        </nav>
    </header>

    <main>
        
        <div class="content-area">
            <h1><b>Kayseri Åehir Rehberi</b></h1>
            
            <div class="image-wrapper"> 
                <img src="images/kayseri.jpg" alt="Kayseri ÅŸehir manzarasÄ±">
            </div>
            
            <div class="text-content">
                <h2 style="margin-top: 0;">Åehir HakkÄ±nda KÄ±sa Bilgi (42)</h2>
                <p>
                **Kayseri**, Ä°Ã§ Anadolu BÃ¶lgesi'nin en Ã¶nemli ticaret, sanayi ve kÃ¼ltÃ¼r merkezlerinden biridir. Åehir, binlerce yÄ±llÄ±k tarihi boyunca **Hititler**, **Roma** ve Ã¶zellikle **SelÃ§uklu** gibi birÃ§ok medeniyete ev sahipliÄŸi yapmÄ±ÅŸtÄ±r.<br>
                Åehrin simgesi olan **Erciyes DaÄŸÄ±**, dÃ¶rt mevsim aktif bir turizm merkezidir. Anadolu'nun ilk tÄ±p merkezi olan **Gevher Nesibe Åifahanesi** gibi SelÃ§uklu mimarisinin Ã¶nemli eserlerini barÄ±ndÄ±rÄ±r.<br>
                **PastÄ±rma**, **sucuk** ve meÅŸhur **mantÄ±**sÄ± ile TÃ¼rkiye mutfaÄŸÄ±nda ayrÄ±calÄ±klÄ± bir yere sahiptir.
                </p>
                
                <div class="quick-links">
                    <h3>HÄ±zlÄ± EriÅŸim BaÄŸlantÄ±larÄ±</h3>
                    <div class="links-container">
                        <a href="#restoranlar" class="link-item" style="text-align: center;">
                            <i class="fas fa-utensils"></i>
                            <span>Restoranlar</span>
                        </a>
                        <a href="#gezi-tarih" class="link-item" style="text-align: center;">
                            <i class="fas fa-landmark"></i>
                            <span>Tarih/Gezi</span>
                        </a>
                        <a href="#kuafÃ¶rler" class="link-item" style="text-align: center;">
                            <i class="fas fa-cut"></i>
                            <span>KuafÃ¶rler</span>
                        </a>
                    </div>
                    
                    
                    <h2 id="gezi-tarih" class="grid-title">Gezi ve Tarihi Yerler</h2>
                    
                    <div class="destinations-grid">
                        
                        <a href="http://kayseri.com/erciyes" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/erciyes_kayak_merkezi.jpg" alt="Erciyes Kayak Merkezi"> </div>
                            <div class="card-content">
                                <h4>Erciyes Kayak Merkezi</h4>
                                <p class="card-description">TÃ¼rkiye'nin en geliÅŸmiÅŸ kayak merkezlerinden biri. KÄ±ÅŸ turizminin yanÄ± sÄ±ra yazÄ±n doÄŸa yÃ¼rÃ¼yÃ¼ÅŸleri iÃ§in de ideal.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-mountain"></i> 3917m</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="http://kayseri.com/kale" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/kayseri_kalesi.jpg" alt="Kayseri Kalesi"> </div>
                            <div class="card-content">
                                <h4>Kayseri Kalesi</h4>
                                <p class="card-description">Åehrin merkezinde yer alan tarihi kale. Roma dÃ¶nemine dayanan temelleri ile SelÃ§uklu ve OsmanlÄ± izlerini taÅŸÄ±r.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-history"></i> Roma-OsmanlÄ±</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="http://kayseri.com/gevher_nesibe" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/gevher_nesibe_sifahanesi.jpg" alt="Gevher Nesibe Åifahanesi ve MÃ¼zesi"> </div>
                            <div class="card-content">
                                <h4>Gevher Nesibe Åifahanesi</h4>
                                <p class="card-description">Anadolu'nun ilk tÄ±p okulu ve hastanesi kompleksi. SelÃ§uklu mimarisinin en Ã¶nemli eserlerindendir.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-hand-holding-medical"></i> 13. YÃ¼zyÄ±l</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>
                        
                        <a href="http://kayseri.com/soganli" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/soganli_vadisi.jpg" alt="SoÄŸanlÄ± Vadisi"> </div>
                            <div class="card-content">
                                <h4>SoÄŸanlÄ± Vadisi</h4>
                                <p class="card-description">Kayseri sÄ±nÄ±rlarÄ± iÃ§indeki Kapadokya bÃ¶lÃ¼mÃ¼. Kaya kiliseleri ve gÃ¼vercinlikleriyle meÅŸhur, doÄŸa harikasÄ± bir vadi.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-church"></i> Kaya Kiliseleri</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                    </div>
                    
                    
                    <h2 id="restoranlar" class="grid-title">PopÃ¼ler Restoranlar (YÃ¶resel Lezzetler)</h2>
                    <div class="restoran-grid">
                        
                        <a href="http://kayseri.com/sut" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/restoran_manti.jpg" alt="HacÄ± ÅÃ¼krÃ¼ MantÄ± Evi"> </div>
                            <div class="card-content">
                                <h4>HacÄ± ÅÃ¼krÃ¼ MantÄ± Evi</h4>
                                <p class="card-description">Kayseri'nin en meÅŸhur mantÄ± restoranÄ±. Geleneksel tariflerle hazÄ±rlanan mantÄ±nÄ±n tadÄ±na bakÄ±n.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-star" style="color: gold;"></i> 4.5 Puan</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                        <a href="http://kayseri.com/pastirma" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/restoran_pastirma.jpg" alt="PastÄ±rmacÄ± SivaslÄ±"> </div>
                            <div class="card-content">
                                <h4>PastÄ±rmacÄ± SivaslÄ±</h4>
                                <p class="card-description">Åehrin en iyi pastÄ±rma ve sucuklarÄ±nÄ± tadabileceÄŸiniz, taze ve kaliteli et Ã¼rÃ¼nleri sunan adres.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-hand-holding-usd"></i> PahalÄ±</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                        <a href="http://kayseri.com/ciÄŸer" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/restoran_ocakbasi.jpg" alt="OcakbaÅŸÄ± Lezzetleri"> </div>
                            <div class="card-content">
                                <h4>CiÄŸerci Apo</h4>
                                <p class="card-description">Lezzetli ve taze ciÄŸer, kebap ve ocakbaÅŸÄ± Ã§eÅŸitleriyle meÅŸhur. Et severlerin vazgeÃ§ilmezi.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-fire-alt"></i> OcakbaÅŸÄ±</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                    </div>
                    
                    
                    <h2 id="kuafÃ¶rler" class="grid-title">PopÃ¼ler KuafÃ¶r ve GÃ¼zellik SalonlarÄ±</h2>
                    <div class="kuafÃ¶r-grid">
                        
                        <a href="http://kayseri.com/kuafÃ¶r_erkek" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/kuafÃ¶r_erkek.jpg" alt="Erkek KuafÃ¶rÃ¼"> </div>
                            <div class="card-content">
                                <h4>Barber's Club</h4>
                                <p class="card-description">Modern tÄ±raÅŸ teknikleri ve saÃ§ kesimleri. Erkekler iÃ§in kaliteli hizmet ve konforlu ortam.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-male"></i> Erkek</span>
                                    <button class="git-button">Ziyaret Et</button>
                                </div>
                            </div>
                        </a>

                        <a href="http://kayseri.com/kuafÃ¶r_kadÄ±n" target="_blank" class="card-item">
                            <div class="card-image"> <img src="images/kuafÃ¶r_kadÄ±n.jpg" alt="KadÄ±n KuafÃ¶rÃ¼"> </div>
                            <div class="card-content">
                                <h4>Glamour GÃ¼zellik Salonu</h4>
                                <p class="card-description">SaÃ§, makyaj ve cilt bakÄ±mÄ± alanÄ±nda profesyonel hizmetler sunan popÃ¼ler kadÄ±n kuafÃ¶rÃ¼.</p>
                                <div class="card-footer">
                                    <span><i class="fas fa-female"></i> KadÄ±n</span>
                                    <button class="git-button">Ziyaret Et</button>
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
