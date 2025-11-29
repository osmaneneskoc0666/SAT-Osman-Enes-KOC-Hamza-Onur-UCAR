
const turkishCities = [
    "adana", "adıyaman", "afyonkarahisar", "ağrı", "amasya", "ankara", "antalya", "artvin",
    "aydın", "balıkesir", "bilecik", "bingöl", "bitlis", "bolu", "burdur", "bursa", "çanakkale",
    "çankırı", "çorum", "denizli", "diyarbakır","düzce", "edirne", "elazığ", "erzincan",
    "erzurum", "eskişehir", "gaziantep", "giresun", "gümüşhane", "hakkari", "hatay", "ığdır",
    "ısparta", "istanbul", "izmir", "kahramanmaraş", "karabük", "karaman", "kars", "kastamonu",
    "kayseri", "kilis", "kırıkkale", "kırklareli", "kırşehir", "kocaeli", "konya", "kütahya",
    "malatya", "manisa", "mardin", "mersin", "muğla", "muş", "nevşehir", "niğde", "ordu",
    "osmaniye", "rize", "sakarya", "samsun", "şanlıurfa", "siirt", "sinop", "sivas", "şırnak",
    "tekirdağ", "tokat", "trabzon", "tunceli", "uşak", "van", "yalova", "yozgat", "zonguldak"
];
document.querySelector('.orta-buton').addEventListener('click', function() {
    const selectedCity = document.getElementById('city-input').value;

    if (selectedCity.toLowerCase() === 'adana') {
        window.open('adana.html');
    }
    else if (selectedCity.toLowerCase() === 'ankara') {
        window.open('ankara.html');
    }
    else if (selectedCity.toLowerCase() === 'zonguldak') {
        window.open('zonguldak.html');
    }
    // ... [Diğer şehir koşulları] ...
    else if (selectedCity.toLowerCase() === 'yozgat') {
        window.open('yozgat.html');
    }
    else if (selectedCity.toLowerCase() === 'yalova') {
        window.open('yalova.html');
    }
    else if (selectedCity.toLowerCase() === 'van') {
        window.open('van.html');
    }
    else if (selectedCity.toLowerCase() === 'uşak') {
        window.open('uşak.html');
    }
    else if (selectedCity.toLowerCase() === 'tunceli') {
        window.open('tunceli.html');
    }
    else if (selectedCity.toLowerCase() === 'trabzon') {
        window.open('trabzon.html');
    }
    else if (selectedCity.toLowerCase() === 'tokat') {
        window.open('tokat.html');
    }
    else if (selectedCity.toLowerCase() === 'tekirdağ') {
        window.open('tekirdağ.html');
    }
    else if (selectedCity.toLowerCase() === 'şırnak') {
        window.open('şırnak.html');
    }
    else if (selectedCity.toLowerCase() === 'sivas') {
        window.open('sivas.html');
    }
    else if (selectedCity.toLowerCase() === 'sinop') {
        window.open('sinop.html');
    }
    else if (selectedCity.toLowerCase() === 'siirt') {
        window.open('siirt.html');
    }
    else if (selectedCity.toLowerCase() === 'şanlıurfa') {
        window.open('şanlıurfa.html');
    }
    else if (selectedCity.toLowerCase() === 'samsun') {
        window.open('samsun.html');
    }
    else if (selectedCity.toLowerCase() === 'sakarya') {
        window.open('sakarya.html');
    }
    else if (selectedCity.toLowerCase() === 'rize') {
        window.open('rize.html');
    }
    else if (selectedCity.toLowerCase() === 'osmaniye') {
        window.open('osmaniye.html');
    }
    else if (selectedCity.toLowerCase() === 'ordu') {
        window.open('ordu.html');
    }
    else if (selectedCity.toLowerCase() === 'niğde') {
        window.open('niğde.html');
    }
    else if (selectedCity.toLowerCase() === 'nevşehir') {
        window.open('nevşehir.html');
    }
    else if (selectedCity.toLowerCase() === 'muş') {
        window.open('muş.html');
    }
    else if (selectedCity.toLowerCase() === 'muğla') {
        window.open('muğla.html');
    }
    else if (selectedCity.toLowerCase() === 'mersin') {
        window.open('mersin.html');
    }
    else if (selectedCity.toLowerCase() === 'mardin') {
        window.open('mardin.html');
    }
    else if (selectedCity.toLowerCase() === 'manisa') {
        window.open('manisa.html');
    }
    else if (selectedCity.toLowerCase() === 'malatya') {
        window.open('malatya.html');
    }
    else if (selectedCity.toLowerCase() === 'kütahya') {
        window.open('kütahya.html');
    }
    else if (selectedCity.toLowerCase() === 'konya') {
        window.open('konya.html');
    }
    else if (selectedCity.toLowerCase() === 'kocaeli') {
        window.open('kocaeli.html');
    }
    else if (selectedCity.toLowerCase() === 'kırşehir') {
        window.open('kırşehir.html');
    }
    else if (selectedCity.toLowerCase() === 'kırklareli') {
        window.open('kırklareli.html');
    }
    else if (selectedCity.toLowerCase() === 'kırıkkale') {
        window.open('kırıkkale.html');
    }
    else if (selectedCity.toLowerCase() === 'kilis') {
        window.open('kilis.html');
    }
    else if (selectedCity.toLowerCase() === 'kayseri') {
        window.open('kayseri.html');
    }
    else if (selectedCity.toLowerCase() === 'kastamonu') {
        window.open('kastamonu.html');
    }
    else if (selectedCity.toLowerCase() === 'kars') {
        window.open('kars.html');
    }
    else if (selectedCity.toLowerCase() === 'karaman') {
        window.open('karaman.html');
    }
    else if (selectedCity.toLowerCase() === 'karabük') {
        window.open('karabük.html');
    }
    else if (selectedCity.toLowerCase() === 'kahramanmaraş') {
        window.open('kahramanmaraş.html');
    }
    else if (selectedCity.toLowerCase() === 'izmir') {
        window.open('izmir.html');
    }
    else if (selectedCity.toLowerCase() === 'istanbul') {
        window.open('istanbul.html');
    }
    else if (selectedCity.toLowerCase() === 'ısparta') {
        window.open('ısparta.html');
    }
    else if (selectedCity.toLowerCase() === 'ığdır') {
        window.open('ığdır.html');
    }
    else if (selectedCity.toLowerCase() === 'hatay') {
        window.open('hatay.html');
    }
    else if (selectedCity.toLowerCase() === 'hakkari') {
        window.open('hakkari.html');
    }
    else if (selectedCity.toLowerCase() === 'gümüşhane') {
        window.open('gümüşhane.html');
    }
    else if (selectedCity.toLowerCase() === 'giresun') {
        window.open('giresun.html');
    }
    else if (selectedCity.toLowerCase() === 'gaziantep') {
        window.open('gaziantep.html');
    }
    else if (selectedCity.toLowerCase() === 'eskişehir') {
        window.open('eskişehir.html');
    }
    else if (selectedCity.toLowerCase() === 'erzurum') {
        window.open('erzurum.html');
    }
    else if (selectedCity.toLowerCase() === 'erzincan') {
        window.open('erzincan.html');
    }
    else if (selectedCity.toLowerCase() === 'elazığ') {
        window.open('elazığ.html');
    }
    else if (selectedCity.toLowerCase() === 'edirne') {
        window.open('edirne.html');
    }
    else if (selectedCity.toLowerCase() === 'düzce') {
        window.open('düzce.html');
    }
    else if (selectedCity.toLowerCase() === 'diyarbakır') {
        window.open('diyarbakır.html');
    }
    else if (selectedCity.toLowerCase() === 'denizli') {
        window.open('denizli.html');
    }
    else if (selectedCity.toLowerCase() === 'çorum') {
        window.open('çorum.html');
    }
    else if (selectedCity.toLowerCase() === 'çankırı') {
        window.open('çankırı.html');
    }
    else if (selectedCity.toLowerCase() === 'çanakkale') {
        window.open('çanakkale.html');
    }
    else if (selectedCity.toLowerCase() === 'bursa') {
        window.open('bursa.html');
    }
    else if (selectedCity.toLowerCase() === 'burdur') {
        window.open('burdur.html');
    }
    else if (selectedCity.toLowerCase() === 'bolu') {
        window.open('bolu.html');
    }
    else if (selectedCity.toLowerCase() === 'bitlis') {
        window.open('bitlis.html');
    }
    else if (selectedCity.toLowerCase() === 'bingöl') {
        window.open('bingöl.html');
    }
    else if (selectedCity.toLowerCase() === 'bilecik') {
        window.open('bilecik.html');
    }
    else if (selectedCity.toLowerCase() === 'balıkesir') {
        window.open('balıkesir.html');
    }
    else if (selectedCity.toLowerCase() === 'aydın') {
        window.open('aydın.html');
    }
    else if (selectedCity.toLowerCase() === 'artvin') {
        window.open('artvin.html');
    }
    else if (selectedCity.toLowerCase() === 'antalya') {
        window.open('antalya.html');
    }
    else if (selectedCity.toLowerCase() === 'amasya') {
        window.open('amasya.html');
    }
    else if (selectedCity.toLowerCase() === 'ağrı') {
        window.open('ağrı.html');
    }
    else if (selectedCity.toLowerCase() === 'afyonkarahisar') {
        window.open('afyonkarahisar.html');
    }
    else if (selectedCity.toLowerCase() === 'adıyaman') {
        window.open('adıyaman.html');
    }
    else {
        alert('Seçtiğiniz şehre ait web sitesi bulunamadı.');
    }
});

let currentFocus = -1;
const input = document.getElementById("city-input");
const listContainer = document.getElementById("autocomplete-list");

// Kullanıcı input alanına her yazdığında bu fonksiyon çalışır
input.addEventListener("input", function(e) {
    let val = this.value;

    // Önceki önerileri temizle
    closeAllLists();

    // Input boşsa bir şey yapma
    if (!val) { return false; }

    // Geçerli aktif öneri indeksi
    currentFocus = -1;

    // Önerilerin ekleneceği div'i oluştur
    const a = document.createElement("DIV");
    a.setAttribute("id", this.id + "autocomplete-list");
    a.setAttribute("class", "autocomplete-items");
    listContainer.appendChild(a);

    // Bütün şehirler arasında döngü yap
    for (let i = 0; i < turkishCities.length; i++) {
        const city = turkishCities[i];
        const normalizedVal = val.toLowerCase();

        // Şehir adı, girilen metni içeriyorsa (indexOf > -1)
        if (city.includes(normalizedVal)) {
            const b = document.createElement("DIV");

            // Eşleşen kısmı kalın (bold) yap
            const startIndex = city.indexOf(normalizedVal);
            const endIndex = startIndex + normalizedVal.length;

            // Eşleşen kısım kalın yapılırken, ilk harfi büyük yapmak için:
            const capitalizedCity = city.charAt(0).toUpperCase() + city.slice(1);
            const displayCity = capitalizedCity.substring(0, startIndex) +
                "<strong>" + capitalizedCity.substring(startIndex, endIndex) + "</strong>" +
                capitalizedCity.substring(endIndex);

            b.innerHTML = displayCity;

            // Input alanına seçilen değeri koymak için gizli bir input ekle
            b.innerHTML += "<input type='hidden' value='" + capitalizedCity + "'>";

            // Bir öğeye tıklandığında:
            b.addEventListener("click", function(e) {
                // Input alanının değerini gizli input'un değeriyle değiştir
                input.value = this.getElementsByTagName("input")[0].value;
                closeAllLists(); // Öneri listesini kapat
            });
            a.appendChild(b);
        }
    }
});

// Klavye ok tuşları ile gezme ve Enter ile seçim yapma
input.addEventListener("keydown", function(e) {
    let x = document.getElementById(this.id + "autocomplete-list");
    if (x) x = x.getElementsByTagName("div");

    if (e.keyCode === 40) { // Aşağı tuşu
        currentFocus++;
        addActive(x);
    } else if (e.keyCode === 38) { // Yukarı tuşu
        currentFocus--;
        addActive(x);
    } else if (e.keyCode === 13) { // Enter tuşu
        e.preventDefault();
        if (currentFocus > -1) {
            if (x) x[currentFocus].click();
        } else {
            document.querySelector('.orta-buton').click();
        }
    }
});

function addActive(x) {
    if (!x) return false;
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    x[currentFocus].classList.add("autocomplete-active");
}

function removeActive(x) {
    for (let i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
    }
}

function closeAllLists(elmnt) {
    const x = document.getElementsByClassName("autocomplete-items");
    for (let i = 0; i < x.length; i++) {
        if (elmnt !== x[i] && elmnt !== input) {
            x[i].parentNode.removeChild(x[i]);
        }
    }
    currentFocus = -1;
}

// Input dışına tıklandığında öneri listesini kapat
document.addEventListener("click", function(e) {
    closeAllLists(e.target);
});


// -------------------------- SÜREKLİ DEĞİŞEN RESİM JAVASCRIPT KISMI --------------------------

const slideshowImages = [
    'Safranbolu.jpg',
    'Ankara.jpg',
    'Istanbul.jpg'
];

let currentImageIndex = 0;
const imageElement = document.getElementById('slideshow-image');
const changeInterval = 4000;

function changeImage() {
    imageElement.style.opacity = 0;

    setTimeout(() => {
        currentImageIndex++;
        if (currentImageIndex >= slideshowImages.length) {
            currentImageIndex = 0;
        }
        imageElement.src = slideshowImages[currentImageIndex] || 'Safranbolu.jpg';
        imageElement.style.opacity = 1;
    }, 1000);
}

setInterval(changeImage, changeInterval);

if (imageElement) {
    imageElement.src = slideshowImages[currentImageIndex] || 'Safranbolu.jpg';
}

// -------------------------- SÜREKLİ DEĞİŞEN RESİM JAVASCRIPT KISMI BİTİŞ --------------------------

// -------------------------- VİDEO OYNATICI JAVASCRIPT KISMI (Sürekli Döngü) --------------------------
const videos = document.querySelectorAll('.video-container video');
let currentVideoIndex = -1; // -1'den başla, ilk çağrıda 0 olacak

function switchVideo(nextIndex) {
    if (videos.length === 0) return;

    const currentVideo = (currentVideoIndex >= 0) ? videos[currentVideoIndex] : null;
    // İndeksi kontrol ederek döngüyü tamamla
    const newNextIndex = nextIndex % videos.length;
    const nextVideo = videos[newNextIndex];

    // 1. Önceki videoyu durdur ve gizle
    if (currentVideo) {
        currentVideo.pause();
        currentVideo.currentTime = 0;
        // Yumuşak geçiş için opaklığı 0 yap
        currentVideo.style.opacity = 0;
    }

    // 2. Sonraki videoyu göstermeye başla
    nextVideo.style.opacity = 1;

    // 3. Sonraki videoyu oynatmayı dene
    nextVideo.currentTime = 0;
    nextVideo.play()
        .then(() => {
            // Başarıyla oynatıldıysa, yeni indeksi ayarla
            currentVideoIndex = newNextIndex;
        })
        .catch(error => {
            // Oynatma hatası olursa (dosya bulunamaz, bozuk, vb.), sonraki videoya geçişi zorla
            console.error("Video oynatma hatası:", nextVideo.src, error);
            // Hata sonrası hemen bir sonraki videoya geçmek için küçük bir gecikme ekle
            setTimeout(() => {
                switchVideo(newNextIndex + 1); // Bir sonraki videoyu dene
            }, 500);
        });

    // 4. Video Bittiğinde Bir Sonrakine Geç
    nextVideo.onended = () => {
        // Yumuşak geçişi sağlamak için kısa bir gecikme ve ardından bir sonraki videoya geç
        setTimeout(() => switchVideo(newNextIndex + 1), 50);
    };
}


// Başlangıç: İlk videoyu başlat
window.addEventListener('load', () => {
    // Tarayıcı kısıtlamaları nedeniyle 1 saniye bekle ve ilk videoyu başlat
    if (videos.length > 0) {
        setTimeout(() => switchVideo(0), 1000);
    }
});
// -------------------------- VİDEO OYNATICI JAVASCRIPT KISMI BİTİŞ --------------------------


// -------------------------- GEZİLECEK YERLER OK KONTROLÜ --------------------------
const cardsContainer = document.getElementById('travel-cards-container');
const leftArrow = document.getElementById('left-arrow');
const rightArrow = document.getElementById('right-arrow');

if (cardsContainer) {
    leftArrow.addEventListener('click', () => {
        cardsContainer.scrollBy({
            left: -270,
            behavior: 'smooth'
        });
    });

    rightArrow.addEventListener('click', () => {
        cardsContainer.scrollBy({
            left: 270,
            behavior: 'smooth'
        });
    });
}
// -------------------------- GEZİLECEK YERLER OK KONTROLÜ BİTİŞİ --------------------------
// güncelleme