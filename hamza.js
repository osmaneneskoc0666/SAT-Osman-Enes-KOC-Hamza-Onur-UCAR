document.addEventListener('DOMContentLoaded', () => {
    
    // ======================================================
    // 1. ŞEHİR ARAMA VE AUTOCOMPLETE (OTOMATİK TAMAMLAMA)
    // ======================================================
    const turkishCities = [
        "Adana", "Adıyaman", "Afyonkarahisar", "Ağrı", "Amasya", "Ankara", "Antalya", "Artvin",
        "Aydın", "Balıkesir", "Bilecik", "Bingöl", "Bitlis", "Bolu", "Burdur", "Bursa", "Çanakkale",
        "Çankırı", "Çorum", "Denizli", "Diyarbakır", "Düzce", "Edirne", "Elazığ", "Erzincan",
        "Erzurum", "Eskişehir", "Gaziantep", "Giresun", "Gümüşhane", "Hakkari", "Hatay", "Iğdır",
        "Isparta", "İstanbul", "İzmir", "Kahramanmaraş", "Karabük", "Karaman", "Kars", "Kastamonu",
        "Kayseri", "Kilis", "Kırıkkale", "Kırklareli", "Kırşehir", "Kocaeli", "Konya", "Kütahya",
        "Malatya", "Manisa", "Mardin", "Mersin", "Muğla", "Muş", "Nevşehir", "Niğde", "Ordu",
        "Osmaniye", "Rize", "Sakarya", "Samsun", "Şanlıurfa", "Siirt", "Sinop", "Sivas", "Şırnak",
        "Tekirdağ", "Tokat", "Trabzon", "Tunceli", "Uşak", "Van", "Yalova", "Yozgat", "Zonguldak"
    ];

    const input = document.getElementById("city-input");
    const listContainer = document.getElementById("autocomplete-list");
    const btnSearch = document.querySelector('.orta-buton');

    // Kullanıcı yazdıkça çalışır
    input.addEventListener("input", function() {
        const val = this.value.toLocaleLowerCase('tr'); // Türkçe karakter uyumlu küçültme
        closeAllLists();
        if (!val) return false;

        const listDiv = document.createElement("DIV");
        listDiv.setAttribute("class", "autocomplete-items");
        listContainer.appendChild(listDiv);

        turkishCities.forEach(city => {
            if (city.toLocaleLowerCase('tr').includes(val)) {
                const item = document.createElement("DIV");
                // Eşleşen kısmı kalın yap (Regex ile büyük/küçük harf duyarsız)
                const regex = new RegExp(val, "gi");
                item.innerHTML = city.replace(regex, (match) => `<strong>${match}</strong>`);
                item.innerHTML += `<input type='hidden' value='${city}'>`;
                
                // Tıklayınca kutuya yaz ve listeyi kapat
                item.addEventListener("click", function() {
                    input.value = this.getElementsByTagName("input")[0].value;
                    closeAllLists();
                    // İstersen tıklar tıklamaz gitmesi için: goToCity(input.value);
                });
                listDiv.appendChild(item);
            }
        });
    });

    // "Keşfet" butonuna tıklayınca
    btnSearch.addEventListener('click', () => {
        goToCity(input.value);
    });

    // Enter tuşuna basınca
    input.addEventListener("keydown", function(e) {
        if (e.key === "Enter") {
            e.preventDefault();
            goToCity(input.value);
        }
    });

    // Sayfaya gitme fonksiyonu (Dinamik Yönlendirme)
    function goToCity(city) {
        if(city) {
            // Şehir ismini "Slug" formatına çevir (ankara, eskisehir, sanliurfa)
            const slug = city.toLocaleLowerCase('tr')
                             .replace(/ğ/g, 'g').replace(/ü/g, 'u').replace(/ş/g, 's')
                             .replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ç/g, 'c')
                             .replace(/\s+/g, '-'); // Boşlukları tire yap
            
            // sehir.php sayfasına yönlendir
            window.location.href = `sehir.php?isim=${slug}`;
        }
    }

    function closeAllLists() {
        while (listContainer.firstChild) {
            listContainer.removeChild(listContainer.firstChild);
        }
    }

    // Dışarı tıklayınca listeyi kapat
    document.addEventListener("click", function(e) {
        if (e.target !== input) {
            closeAllLists();
        }
    });


    // ======================================================
    // 2. SLIDER / MANŞET RESİM DEĞİŞTİRME (PÜRÜZSÜZ GEÇİŞ)
    // ======================================================
    const slideImages = document.querySelectorAll('.slide-img');
    const images = [
        "https://images.unsplash.com/photo-1524231757912-21f4fe3a7200?q=80&w=2071", // İstanbul
        "https://images.unsplash.com/photo-1622587853578-dd1bf9608d26?q=80&w=2070", // Kapadokya
        "https://images.unsplash.com/photo-1527838832700-5059252407fa?q=80&w=1998", // Ankara
        "https://images.unsplash.com/photo-1541432901042-2d8bd64b4a6b?q=80&w=2070"  // Antalya
    ];

    let imgIndex = 0;
    // Hangi resim elementinin (0. veya 1.) aktif olduğunu takip eder
    let activeElementIndex = 0; 

    // İki resim elementi de varsa döngüyü başlat
    if (slideImages.length === 2) { 
        setInterval(() => {
            // Sıradaki resim URL'sinin indeksini belirle
            imgIndex = (imgIndex + 1) % images.length;
            
            // Şu anki aktif ve bir sonraki aktif olacak elementleri belirle
            const currentImageElement = slideImages[activeElementIndex];
            // 0 ise 1, 1 ise 0 yap (Nöbetleşe)
            const nextElementIndex = (activeElementIndex + 1) % 2;
            const nextImageElement = slideImages[nextElementIndex];
            
            // Yeni resmi, arka plandaki (görünmeyen) elemente yükle
            nextImageElement.src = images[imgIndex];

            // Resim arka planda tamamen yüklendiğinde geçişi başlat
            nextImageElement.onload = () => {
                // Yeni resme 'active' sınıfını ekle (CSS transition ile yavaşça belirir)
                nextImageElement.classList.add('active');
                
                // Eski resimden 'active' sınıfını kaldır (CSS transition ile yavaşça kaybolur)
                currentImageElement.classList.remove('active');

                // Aktif element indeksini güncelle
                activeElementIndex = nextElementIndex;
            };

        }, 5000); // 5 saniyede bir değiştir
    }

    // ======================================================
    // 3. KARTLARI KAYDIRMA (SAĞ-SOL OKLAR)
    // ======================================================
    const cardsContainer = document.getElementById('travel-cards-container');
    const leftArrow = document.getElementById('left-arrow');
    const rightArrow = document.getElementById('right-arrow');

    if (cardsContainer && leftArrow && rightArrow) {
        leftArrow.addEventListener('click', () => {
            cardsContainer.scrollBy({ left: -300, behavior: 'smooth' });
        });

        rightArrow.addEventListener('click', () => {
            cardsContainer.scrollBy({ left: 300, behavior: 'smooth' });
        });
    }


    // ======================================================
    // 4. RESİM YÜKLEME VE ÖNİZLEME (UPLOAD)
    // ======================================================
    const fileInput = document.getElementById('image-upload');
    const uploadedContainer = document.getElementById('uploaded-images');

    if (fileInput && uploadedContainer) {
        fileInput.addEventListener('change', function() {
            Array.from(this.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'uploaded-image-card';
                        div.innerHTML = `<img src="${e.target.result}" alt="Yüklenen Resim">`;
                        uploadedContainer.appendChild(div);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }

});