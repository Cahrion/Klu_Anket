$(document).ready(function(){
    $("button").click(function(){
        var zorunluAlanlar = $(".zorunluAlan");
        var zorunluYapi    = [];
        $.each(zorunluAlanlar, function(key, val){
            var zorunluKisim = $(val).attr("value").split("-");
            var groupName = zorunluKisim[0];
            var soruName  = zorunluKisim[1];
            if(isNaN(zorunluYapi[groupName])){
                zorunluYapi[groupName] = [];
            }
            zorunluYapi[groupName][key] = soruName;
        });

        var anketAlanCevaplarListesi = {};
        var anketCevaplarListesi = {};
        var anketAlanlar = $(".anketAlan");
        var hata = 0;
        $.each(anketAlanlar, function(keyIlk, value){ // Anket grup verisi (Birden fazla grup bulunursa bu belirteç olacaktır.)
            var anketSoruCevaplari = $(value).children(".table").children("tbody").children("tr");
            $.each(anketSoruCevaplari, function(keyOrta, value){ // Anket soru verisi (Birden fazla soru bulunursa bu belirteç olacaktır.)
                var anketSoruCevap = $(value).children(".soruCevaplari");
                $.each(anketSoruCevap, function(keySon, value){ // Anket şık verisi (Birden fazla şık bulunursa bu belirteç olacaktır.)
                    var anketCevap = $(value).children(".form-check").children(".form-check-input").prop("checked");
                    if(anketCevap){
                        anketCevaplarListesi[keyOrta] = $(value).children(".form-check").children(".form-check-input").val();
                    }else{

                        // Sistem çalışmadı mola kararı aldım. 

                        // var soruSplit = $(value).children(".form-check").children(".form-check-input").val().split("-");
                        // var soruSplitSoruNum = soruSplit[0];
                        // $.each(zorunluYapi[keyIlk], function(keySoru, zorunluSorular){
                        //     if(zorunluSorular = soruSplitSoruNum){
                        //         hata = 1;
                        //     }
                        // });
                    }
                });
            });
            // keyIlk = 0'dan başlar ama grup bilgisine gerek yoktur.
            anketAlanCevaplarListesi[keyIlk]    = anketCevaplarListesi;
            anketCevaplarListesi                = {}; // dataları sıfırlayalım
        }); 
        if(hata){
            return alert("Lütfen (*) gerekli kısımları doldurunuz.");
        }
        // Konum verisini sürekli olarak buradan değiştirmek yerine bağlantı kısmından istenilen konumu aldım. (publicAnketler/anketLoading)
        var pathKonum          = window.location.pathname.split("/");
        var originKonum        = window.location.origin; 
        var needKonum          = originKonum +  "/" + pathKonum[1] + "/" + pathKonum[2] + "/" + pathKonum[3];
        var anketBilgisi       = $(this).attr("id");

        $.post(needKonum + '/anketLoading/' + anketBilgisi, {queryString: anketAlanCevaplarListesi}, function(data) 
        {
        if(data.length > 0)
        {
            alert("Anket bilgileri başarıyla gönderildi. Anketimize katıldığınız için teşekkür ederiz.");
            window.location.href = "https://www.klu.edu.tr/";
        }
        });  
    });
});