var base_url = $("base").attr("href");
var maksimum = 850;

$(document).ready(function () {
    $("#myModal").modal('show');

    // Seçenek kalıp alan
    var intervalFlag = true;
    $(".soruCevaplari").click(function () {
        if (intervalFlag) {
            intervalFlag = false;
            var interval = 20;
            var veriT = $(this).children(".soruSecenekler");
            var veriTIntial = $(veriT).css("box-shadow");
            var zamanlayici = setInterval(function () {
                interval -= 1;
                $(veriT).css("transform", "scale(1.4)");
                $(veriT).css("box-shadow", "0 0 5px " + interval + "px #7db1fe");
                if (interval == 0) {
                    $(veriT).css("transform", "scale(1)");
                    $(veriT).css("box-shadow", veriTIntial);
                    clearInterval(zamanlayici);
                    intervalFlag = true;
                }
            }, 10);
            $(this).children(".soruSecenekler").prop('checked', true);
        }
    });

    $(".publicAnketGonder").click(function () {
        var zorunluAlanlar = $(".zorunluAlan");
        var zorunluYapi = [];
        $.each(zorunluAlanlar, function (key, val) {
            var zorunluKisim = $(val).attr("value");
            zorunluYapi[key] = zorunluKisim;
        });

        var anketAlanCevaplarListesi = {};
        var anketCevaplarListesi = {};
        var anketAlanlar = $(".anketAlan");
        var hata = 0;
        $.each(anketAlanlar, function (keyIlk, value) { // Anket grup verisi (Birden fazla grup bulunursa bu belirteç olacaktır.)
            var anketSoruCevaplari = $(value).children("table").children("tbody").children("tr");
            $.each(anketSoruCevaplari, function (keyOrta, value) { // Anket soru verisi (Birden fazla soru bulunursa bu belirteç olacaktır.)
                var anketSoruCevap = $(value).children(".soruCevaplari");
                $.each(anketSoruCevap, function (keySon, value) { // Anket şık verisi (Birden fazla şık bulunursa bu belirteç olacaktır.)
                    var anketCevap = $(value).children(".soruSecenekler").prop("checked");
                    if (anketCevap) {
                        anketCevaplarListesi[keyOrta] = $(value).children(".soruSecenekler").val();
                        return 0;
                    }
                });
            });
            $.each(anketCevaplarListesi, function (keyZorunlu, valZorunlu) { // Cevaplanmış şıkları alıyoruz.
                var valZorunluSplit = valZorunlu.split("-");
                var valZorunluSoru = valZorunluSplit[0];
                var valZorunluCevap = valZorunluSplit[1];
                $.each(zorunluYapi, function (keyZorunlu2, valZorunlu2) { // Zorunlu alanlardan geçip geçmediğine bakıyoruz.
                    var valZorunlu2Split = valZorunlu2.split("-");
                    var valZorunlu2Group = valZorunlu2Split[0];
                    var valZorunlu2Soru = valZorunlu2Split[1];

                    if ((valZorunlu2Group == keyIlk) && (valZorunluSoru == valZorunlu2Soru)) { // Eğer geçmişse sayaca 1 ekleyip yeniden tekrar ediyoruz.
                        hata += 1;
                    }
                });
            });
            // keyIlk = 0'dan başlar ama grup bilgisine gerek yoktur.
            anketAlanCevaplarListesi[keyIlk] = anketCevaplarListesi;
            anketCevaplarListesi = {}; // dataları sıfırlayalım
        });
        if (zorunluYapi.length != hata) { // Sayılar eşit değilse dolmayan kısım vardır diyoruz.
            return alert("Lütfen (*) zorunlu kısımları doldurmayı unutmayınız.");
        }
        // Görev yeri bilgilerinin alımı
        var brans = $(".fakulteAlan").attr("name");
        var fakulte = $(".fakulteSelect").val();
        var birim = $(".birimSelect").val();
        if ((fakulte != "" && birim != "") || ((brans == "idari" || brans == "herkes") && fakulte != "" && birim == undefined)) {
            if (birim == undefined) {
                birim = "";
            }
            var branslar = [brans, fakulte, birim];
        } else {
            return alert("Lütfen branş bilgilerinizi giriniz.");
        }

        // Anket görüş alımı
        if($("#anketGorus").length > 0){
            var anketGorus = $("#anketGorus").val();
            if (anketGorus.length > maksimum) {
                return alert("Lütfen görüşünüzü maksimum belirtilen kelime sayısına uygun şekilde değiştiriniz.");
            }
        }else{
            var anketGorus = "";
        }
        // ID alımı
        var anketBilgisi = $(this).attr("id");
        // Canvas
        var canvasSelector = $(".canvasSelector").val();
        if (canvasSelector == "") {
            return alert("Lütfen güvenlik kodunu giriniz.");
        }
        $.post(base_url + '/publicAnketler/anketLoading/' + anketBilgisi, { queryBrans: branslar, queryProtocol: canvasSelector.toUpperCase(), queryString: anketAlanCevaplarListesi, anketGorus: anketGorus }, function (data) {
            if (data.length > 0) {
                if (data == 1) {
                    alert("Anket bilgileri başarıyla gönderildi. Anketimize katıldığınız için teşekkür ederiz.");
                    window.location.href = "https://www.klu.edu.tr/";
                } else if (data == 0) {
                    alert("Lütfen boş anket göndermeye çalışmayın.");
                } else if (data == 2) {
                    alert("Lütfen güvenlik kodunu kontrol ediniz.");
                } else if (data == 3) {
                    alert("Lütfen branş bilgilerinizi kontrol ediniz.");
                } else if (data == 4) {
                    alert("Lütfen görüşünüzü maksimum belirtilen kelime sayısına uygun şekilde değiştiriniz.");
                } else {
                    alert("Lütfen (*) zorunlu kısımları doldurmayı unutmayınız.");
                }
            }
        });
    });
});
var islem;
function baslat() {
    islem = document.getElementById("guvenlikkodualani").getContext("2d");
    islem.fillStyle = "#F1F1F1";
    degistir();
}
function degistir() {
    $.post(base_url + '/publicAnketler/captchaCreator', function (data) {
        if (data.length > 0) {
            islem.clearRect(0, 0, 135, 50);
            islem.fillRect(0, 0, 135, 50);
            islem.font = "28px calibri";
            islem.strokeText(data, 12, 34);
        }
    });
}

function anketGorusKeyPress(node) {
    var uzunluk = $(node).val().length;

    if (uzunluk >= maksimum) {
        var deger = $(node).val();
        var olustur = deger.substr(0, maksimum);
        $(node).val(olustur);
        $(".Kullanilan").css("color", "red");
        $(".Kullanilan").text(maksimum);
    } else {
        var deger = $(node).val();
        $(".Kullanilan").css("color", "grey");
        $(".Kullanilan").text(uzunluk);
    }
}
// Brans seçme alanı
function fakulteChange(node) {
    // Alt birimleri olmayan yapılar getirilecek.
    var gelenBrans = $(".fakulteAlan").attr("name");
    if (gelenBrans != "idari" && gelenBrans != "herkes") {
        var html = `
            <div class="mb-3 birimAlan">
                <label for="birim" class="form-label" style="font-weight:bold">Görev birim yeriniz</label>
                <select class="form-control birimSelect" name="birim" id="birim">
                    <option class="birim" value="">Lütfen seçiniz</option>
                    <option class="birim" value="1">Muhendislik</option>
                    <option class="birim" value="2">Hukuk</option>
                </select>
        </div>
        `;
        if ($(".gorevBilgisi").children("div").length < 2) { // Sayfada gösterimde olan 3 veya daha fazla veri varsa eklemedik.
            $(".fakulteAlan").after(html);
        }
    }
}