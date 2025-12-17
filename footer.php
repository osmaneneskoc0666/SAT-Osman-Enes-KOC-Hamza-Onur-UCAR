<footer class="footer">
    <style>
        .footer {
            background-color: #000000d8; 
            color: white;
            padding: 50px 0; /* Üstten alttan biraz daha boşluk (Ferahlık için) */
            margin-top: 50px;
            font-family: 'Poppins', sans-serif;
        }
        .footer-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px; /* Mobilde kenarlara yapışmasın diye güvenlik boşluğu */
        }
        
        /* SAĞ TARAFTAKİ LİNKLER KUTUSU */
        .right-links {
            display: flex;
            margin-right: 40px; /* Sağ kenardan biraz daha içeri aldık */
            gap: 95px; /* Bloklar arası boşluk (80px + 15px artırdık) */
        }

        .footer-col h4 {
            color: #fff; /* Yeşil zemin üzerinde Beyaz başlık daha net okunur */
            margin-bottom: 20px;
            font-size: 19px;
            font-weight: 600;
            border-bottom: 2px solid rgba(255,255,255,0.3); /* Başlık altına hafif çizgi */
            padding-bottom: 5px;
            display: inline-block;
        }

        .footer-col a, .footer-col p {
            color: #f0f0f0; /* Hafif kırık beyaz */
            text-decoration: none;
            display: block;
            margin-bottom: 10px;
            font-size: 15px;
            transition: 0.3s;
        }

        .footer-col a:hover {
            color: #ffeb3b; /* Üzerine gelince Sarı olsun */
            transform: translateX(5px); /* Hafif sağa kaysın */
        }

        .footer-bottom {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.2);
            font-size: 13px;
            color: #e0e0e0;
        }
    </style>

    <div class="footer-content">
        
        <img src="images/altt.png" alt="Logo" style="width: 430px; height: auto; display:block;">

        <div class="right-links">
            <div class="footer-col">
                <h4>Hakkımızda</h4>
                <a href="ekip.php">Ekibimiz</a>
                <a href="hakkimizda.php">Hakkımızda</a>
            </div>
            <div class="footer-col">
                <h4>Hizmetler</h4>
                <p>Şehir Rehberleri</p>
                <p>Rota Planlama</p>
                <p>Rezervasyon</p>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
       &copy; 2025 Gezi Rehberi. Bu bir proje çalışmasıdır.
    </div>
</footer>

<script src="js/hamza.js"></script>
</body>
</html>