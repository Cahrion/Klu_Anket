$(document).ready(function(){
    $("button").click(function(){
        var anketAlanCevaplarListesi = {};
        var anketCevaplarListesi = {};
        var anketAlanlar = $(".anketAlan");
        $.each(anketAlanlar, function(keyIlk, value){ // Anket grup verisi (Birden fazla grup bulunursa bu belirteç olacaktır.)
            var anketSoruCevaplari = $(value).children(".soruCevaplari");
            $.each(anketSoruCevaplari, function(keyOrta, value){ // Anket soru verisi (Birden fazla soru bulunursa bu belirteç olacaktır.)
                var anketSoruCevap = $(value).children(".row").children("div");
                $.each(anketSoruCevap, function(keySon, value){ // Anket şık verisi (Birden fazla şık bulunursa bu belirteç olacaktır.)
                    var anketCevap = $(value).children(".form-check").children(".form-check-input").prop("checked");
                    if(anketCevap){
                        // keyOrta = 0'dan başladığı için 1 ekledik.
                        anketCevaplarListesi[keyOrta] = $(value).children(".form-check").children(".form-check-input").val();
                    }
                });
            });
            // keyIlk = 0'dan başlar ama grup bilgisine gerek yoktur.
            anketAlanCevaplarListesi[keyIlk]    = anketCevaplarListesi;
            anketCevaplarListesi                = {}; // dataları sıfırlayalım
        }); 

        // Konum verisini sürekli olarak buradan değiştirmek yerine bağlantı kısmından istenilen konumu aldım. (publicAnketler/anketLoading)
        var pathKonum          = window.location.pathname.split("/");
        var originKonum        = window.location.origin; 
        var needKonum          = originKonum +  "/" + pathKonum[1] + "/" + pathKonum[2] + "/" + pathKonum[3];
        var anketBilgisi       = $(this).attr("id");



        // Sorun Yaşadım. Obje gitmiyor birdahaki çalışmada bakacağım.. (Mola)
        $.post(needKonum + '/anketLoading/' + anketBilgisi, {queryString: anketAlanCevaplarListesi}, function(data) 
        {
        if(data.length > 0)
        {
            document.write(data);
            alert("Anket bilgileri başarıyla gönderildi. Anketimize katıldığınız için teşekkür ederiz.");
            window.location.href = "https://www.klu.edu.tr/";
        }
        });  
    });
});