var base_url = $("base").attr("href");
var renkler = ["rgb(168, 234, 135)","rgb(234, 228, 135)","rgb(234, 144, 135)", "rgb(135, 234, 193)", "rgb(126, 189, 255)","rgb(204, 169, 126)", "rgb(11, 94, 215)"];

function scrollSelector(){
    var hesapla 		= $("body").get(0).scrollHeight;
    if(hesapla > 2000){
        $(".ustVeriAlan").show();
    }else{
        $(".ustVeriAlan").hide();
    }
}

function secretNumCreator(gelenSayi){
    if(gelenSayi < 10){
        var secretNumVal = gelenSayi;
        var htmlSecretNum = `
            <i class="secretNumFont fa-solid fa-` + secretNumVal + `"></i>
        `;
    }else if((gelenSayi < 100) && (gelenSayi >= 10)){
        var secretNumVal = gelenSayi.toString().split("");
        var htmlSecretNum = `
            <i class="secretNumFont fa-solid fa-` + secretNumVal[0] + `"></i>
            <i class="secretNumFont fa-solid fa-` + secretNumVal[1] + `"></i>
        `;
    }else if((gelenSayi < 1000) && (gelenSayi >= 100)){
        var secretNumVal = gelenSayi.toString().split("");
        var htmlSecretNum = `
            <i class="secretNumFont fa-solid fa-` + secretNumVal[0] + `"></i>
            <i class="secretNumFont fa-solid fa-` + secretNumVal[1] + `"></i>
            <i class="secretNumFont fa-solid fa-` + secretNumVal[2] + `"></i>
        `;
    }
    return htmlSecretNum;
}

function anketIcerigiEkle(node){
    $(node).siblings(".anketGroupEkle").css("display", "none");

    var gelenName = $(node).parent().attr("name"); // 1soru1
    var gelenNameSplit = gelenName.split("soru");
    var gelenNameSplitAr = parseInt(gelenNameSplit[1]) + 1;
    var istenenName = gelenNameSplit[0] + "soru" + gelenNameSplitAr;

    var htmlSecretNum = secretNumCreator(gelenNameSplitAr);
    var myColor = $(node).parent().siblings(".anketGroupHeadCoverager").children(".renkAlani").css("background-color");
    var html = `
        <div class="anketCoverager" style="border-left: 4px solid ` + myColor + `" name="` + (istenenName) + `">
            <div class="secretNum">
                ` + htmlSecretNum + `
            </div>
            <div class="anketSoru">
                <input type="text" placeholder="Soru" class="anketSoruVal">
            </div>
            <div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
                <input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' id="` + (istenenName) + `" checked>
                <label class="form-check-label anketZorunlulukLabel" for="` + (istenenName) + `" style="color:darkred;font-weight:bold">Zorunlu</label>
            </div>
            <!-- Kullan??c?? soru ekleme alan?? -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
            <span class="anketIcerigiSil" onclick="anketIcerigiSil(this)">Soru Sil</span>
    `;
    var htmlDefault = `
        </div>
    `;
    var htmlPlus = `
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
    `;
    var mainGroupIndex = gelenNameSplit[0];
    var mainSoruIndex  = gelenNameSplit[1];
    var boyut = $(".GroupCoverager[name='" + mainGroupIndex + "'] .anketCoverager").length;

    if(boyut == mainSoruIndex){
        $(node).parent().after(html + htmlPlus + htmlDefault);
    }else{
        var gelenUstSorular = $(node).parent().siblings(".anketCoverager");
        $.each(gelenUstSorular, function(key, value){
            var gelenUstName        = $(value).attr("name");
            var gelenUstNameSpl     = gelenUstName.split("soru");
            var ustSoruIndex        = gelenUstNameSpl[1];
            if(parseInt(ustSoruIndex) > parseInt(mainSoruIndex)){
                var newVal =  mainGroupIndex + "soru" + (parseInt(ustSoruIndex)+1);
                $(value).attr("name", newVal);

                $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").attr("id", newVal);
                $(value).children(".anketGroupcompulsory").children(".anketZorunlulukLabel").attr("for", newVal);

                var newHtmlSecretNum = secretNumCreator((parseInt(ustSoruIndex)+1));
                $(value).children(".secretNum").html(newHtmlSecretNum);
            }
        });
        $(node).parent().after(html + htmlDefault);
    }

}
function anketIcerigiSil(node){
    var html = `
        <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
        <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
    `;
    var mainName = $(node).parent().attr("name"); // 1soru1
    var mainNameSpl = mainName.split("soru");
    var mainGroupIndex = mainNameSpl[0];
    var mainSoruIndex  = mainNameSpl[1];

    var boyut = $(".GroupCoverager[name='" + mainGroupIndex + "'] .anketCoverager").length;

    if(boyut == mainSoruIndex){
        $(node).parent().prev().append(html);
        $(node).parent().remove();
    }else{
        var gelenUstSorular = $(node).parent().siblings(".anketCoverager");
        $.each(gelenUstSorular, function(key, value){
            var gelenUstName        = $(value).attr("name");
            var gelenUstNameSpl     = gelenUstName.split("soru");
            var ustSoruIndex        = gelenUstNameSpl[1];
            if(parseInt(ustSoruIndex) > parseInt(mainSoruIndex)){
                var newVal =  mainGroupIndex + "soru" + (parseInt(ustSoruIndex)-1);
                $(value).attr("name", newVal);
                $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").attr("id", newVal);
                $(value).children(".anketGroupcompulsory").children(".anketZorunlulukLabel").attr("for", newVal);
                var newSecretNum = secretNumCreator((parseInt(ustSoruIndex)-1));
                $(value).children(".secretNum").html(newSecretNum);
            }
        });
        $(node).parent().remove();
    }
}
function soruSecenekEkle(node){
    $(node).css("display", "none");

    var gelenName = $(node).parent().parent().attr("name"); // 1secenek1
    var gelenNameSplit = gelenName.split("secenek");
    var gelenNameSplitAr = parseInt(gelenNameSplit[1]) + 1;
    var istenenName = gelenNameSplit[0] + "secenek" + gelenNameSplitAr;

    var html = `
        <div class="anketSecenekler row" name="` + istenenName + `">
            <div class="col-8 col-sm-6 col-md-7 col-lg-9 col-xl-10 anketSeceneklerIcAlan">
                <input type="text" placeholder="Se??enekler" class="anketGroupOptions">
            </div>
            <!-- Kullan??c?? ????k ekleme alan?? -->
            <div class="col-4 col-sm-6 col-md-5 col-lg-3 col-xl-2 text-center secenekAlan">
                <button class="btn btn-primary soruSecenekSil" onclick="soruSecenekSil(this)"><i class="fa-solid fa-minus"></i></button>
                <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
            </div>
        </div>
    `;
    $(node).parent().parent().parent().append(html);
}
function soruSecenekSil(node){
    var html = `
        <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
    `;
    var mainName = $(node).parent().parent().attr("name"); // 1secenek1
    var mainNameSpl         = mainName.split("secenek");
    var mainGroupIndex      = mainNameSpl[0];
    var mainSecenekIndex    = mainNameSpl[1];

    var boyut = $(".GroupCoverager[name='" + mainGroupIndex + "'] .anketGroupHeadCoverager .anketSecenekler").length;
    if(boyut == mainSecenekIndex){
        $(node).parent().parent().prev().children(".secenekAlan").append(html);
        $(node).parent().parent().remove();
    }else{
        var gelenUstSorular = $(node).parent().parent().siblings(".anketSecenekler");
        $.each(gelenUstSorular, function(key, value){
            var gelenUstName        = $(value).attr("name");
            var gelenUstNameSpl     = gelenUstName.split("secenek");
            var ustSoruIndex        = gelenUstNameSpl[1];
            if(parseInt(ustSoruIndex) > parseInt(mainSecenekIndex)){
                $(value).attr("name", mainGroupIndex + "secenek" + (parseInt(ustSoruIndex)-1));
            }
        });
        $(node).parent().parent().remove();
    }
}
function anketGroupEkle(node){
    var ustAlan     = $(node).parent().parent();
    var renk        = $(ustAlan).children(".anketGroupHeadCoverager").children(".renkAlani").css("background-color");
    var renkIndex       = $.inArray(renk, renkler);
    if(renkIndex == (renkler.length-1)){
        var renkVeri    = renkler[0];
    }else{
        var renkVeri    = renkler[renkIndex + 1];
    }

    var gelenName = $(node).parent().parent().attr("name"); // 1
    var gelenNameSplitAr = parseInt(gelenName) + 1;
    var istenenName = gelenNameSplitAr;


    var html = `
    <div class="GroupCoverager mt-4" name="` + istenenName + `">
        <div class="anketGroupHeadCoverager">
            <span class="anketGroupSil" onclick="anketGroupSil(this)">Grup Sil</span>
            <div class="renkAlani" onclick='renkAlani(this)' style="background-color: ` + renkVeri + `"></div>
            <div class="baslik">
                <input type="text" placeholder="Grup Ba??l??????" class="anketGroupHeadCoveragerHeader">
            </div>
            <div class="baslikMetni">
                <textarea class="text-muted anketGroupHeadCoveragerHeadText" cols="30" rows="10" placeholder="Grup detay bilgisi"></textarea>
            </div>
            <div class="anketSecenekler row" name="` + istenenName + `secenek1">
                <div class="col-8 col-sm-6 col-md-7 col-lg-9 col-xl-10 anketSeceneklerIcAlan">
                    <input type="text" placeholder="Se??enekler" class="anketGroupOptions">
                </div>
                <!-- Kullan??c?? ????k ekleme alan?? -->
                <div class="col-4 col-sm-6 col-md-5 col-lg-3 col-xl-2 text-center secenekAlan">
                    <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
                </div>
            </div>
        </div>
        <div class="anketCoverager" style="border-left: 6px solid ` + renkVeri + `" name="` + istenenName + `soru1">
            <div class="secretNum">
                <i class="secretNumFont fa-solid fa-1"></i>
            </div>
            <div class="anketSoru">
                <input type="text" placeholder="Soru" class="anketSoruVal">
            </div>
            <div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
                <input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' id="` + istenenName + `soru1" checked>
                <label class="form-check-label anketZorunlulukLabel" for="` + istenenName + `soru1" style="color:darkred;font-weight:bold">Zorunlu</label>
            </div>
            <!-- Kullan??c?? soru ekleme alan?? -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
        </div>
    </div>
    `;
    $(ustAlan).after(html);
}
function anketGroupSil(node){
    $(node).parent().parent().remove();
}
function renkAlani(node){
    var renk = $(node).css("background-color");
    var renkIndex = $.inArray(renk, renkler);
    var randomInt = Math.floor((Math.random() * (renkler.length-1)) + 1);
    if(randomInt > (renkler.length - 1)){
        randomInt -= (renkler.length - 1);
    }
    if(renkIndex == randomInt){
        randomInt -= 1;
    }
    $(node).css("background-color", renkler[randomInt]);
    $(node).parent().siblings().css("border-left", "4px solid " + renkler[randomInt])
}
function zorunlulukFaktor(node){
    if($(node).prop("checked")){
        $(node).siblings("label").css("color","darkred");
    }else{
        $(node).siblings("label").css("color","#c0c5c0");
    }
}
function anketGirisZorunluluk(node){
    if($(node).prop("checked")){
        $(node).siblings("label").css("color","darkred");
    }else{
        $(node).siblings("label").css("color","black");
    }
}


$(document).ready(function(){
    // Gelen bir ??ok veriye kar????l??k bulabilmek amac??yla foreach yap??s??ndan gelen verileri al??yor ve bunlar serialize ederek sisteme eklemeye ??al??????yoruz
    $(".veriGonder").click(function(){
        var OncekiHal = $(this).html();
        $(".veriGonder").prop("disabled", true);
        $(".veriGonder").html('<i class="fa-solid fa-arrows-rotate"></i> Anket Olu??turuluyor...');
        // ??st anket verilerin al??m??.
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children(".anketHeadCoveragerHeader").val(); // Anket Ba??l??????
        if(anketBaslik == ""){
            alert("L??tfen ba??l??k k??sm??n?? doldurunuz.");
            $(".anketHeadCoverager").children(".baslik").children("input").focus();
            $(".veriGonder").html(OncekiHal);
            $(".veriGonder").prop("disabled", false);
            return $(".anketHeadCoverager").children(".baslik").children("input").attr("placeholder", "Buras?? bo?? ge??ilemez.");
        }
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children(".anketHeadCoveragerHeadText").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children(".anketHeadCoveragerExplanationText").val(); // Anket A????klama Metni
        var anketKitle      = $("#formKitleSelected").val();
        var anketGiris      = $("#anketGirisZorunluluk").prop("checked"); // Anket Giri??
        var anketGorus      = $("#detaySormaAlan").prop("checked"); // Anket Detay sorulsun mu 

        if(anketKitle == ""){
            alert("L??tfen hitap edilen kitleyi se??iniz.");
            $(".veriGonder").html(OncekiHal);
            $(".veriGonder").prop("disabled", false);
            return $("#formKitleSelected").focus();
        }
        if(anketGiris){
            anketGiris = 1;
        }else{
            anketGiris = 0;
        }
        if(anketGorus){
            anketGorus = 1;
        }else{
            anketGorus = 0;
        }
        
        var temelAnketVerileri = [anketBaslik,anketBaslikM,anketBaslikA,anketKitle,anketGiris,anketGorus];

        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m
        var secenekList = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m
        var soruList    = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children(".anketGroupHeadCoveragerHeader").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children(".anketGroupHeadCoveragerHeadText").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor oldu??unu g??rd??k

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".anketSeceneklerIcAlan").children(".anketGroupOptions").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu y??zden yeniden foreach yap??s??na tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){

                var anketSoru               = $(value).children(".anketSoru").children(".anketSoruVal").val();
                var anketSoruZorunluluk     = $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin i??indeki veriyi temizlememek gerekti??inden temizledik.
            soruList        = {}; // Listelerin i??indeki veriyi temizlememek gerekti??inden temizledik.
        });

        $.post(base_url + '/ownerController/anketAdd', {queryName: temelAnketVerileri,queryString: UstList}, function(data)
        {
        if(data.length > 0)
        {
            window.location.href = window.location.href + '/adminAnket';
        }
        });
    });
});

$(document).ready(function(){
    // Gelen bir ??ok veriye kar????l??k bulabilmek amac??yla foreach yap??s??ndan gelen verileri al??yor ve bunlar serialize ederek sisteme eklemeye ??al??????yoruz
    $(".veriGuncelle").click(function(){
        var OncekiHal = $(this).html();
        $(".veriGuncelle").prop( "disabled", true);
        $(".veriGuncelle").html('<i class="fa-solid fa-arrows-rotate"></i> Anket G??ncelleniyor...');
        // ??st anket verilerin al??m??.
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children(".anketHeadCoveragerHeader").val(); // Anket Ba??l??????
        if(anketBaslik == ""){
            alert("L??tfen ba??l??k k??sm??n?? doldurunuz.");
            $(".veriGuncelle").prop("disabled", false);
            $(".veriGuncelle").html(OncekiHal);
            $(".anketHeadCoverager").children(".baslik").children("input").focus();
            return $(".anketHeadCoverager").children(".baslik").children("input").attr("placeholder", "Buras?? bo?? ge??ilemez.");
        }
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children(".anketHeadCoveragerHeadText").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children(".anketHeadCoveragerExplanationText").val(); // Anket A????klama Metni
        var anketKitle      = $("#formKitleSelected").val();
        var anketGiris      = $("#anketGirisZorunluluk").prop("checked"); // Anket Giri??
        var anketGorus      = $("#detaySormaAlan").prop("checked"); // Anket Detay sorulsun mu 
        var anketID         = $(".anketHeadCoverager").attr("id"); // Anket Metni
        if(anketKitle == ""){
            alert("L??tfen hitap edilen kitleyi se??iniz.");
            $(".veriGuncelle").prop( "disabled", false);
            $(".veriGuncelle").html(OncekiHal);
            return $("#formKitleSelected").focus();
        }
        if(anketGiris){
            anketGiris = 1;
        }else{
            anketGiris = 0;
        }
        if(anketGorus){
            anketGorus = 1;
        }else{
            anketGorus = 0;
        }
        var temelAnketVerileri = [anketBaslik,anketBaslikM,anketBaslikA,anketKitle,anketGiris,anketGorus,anketID];

        // Anket i??inin verilerinin al??m??.
        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m
        var secenekList = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m
        var soruList    = {};  // Liste atamas?? kullanarak s??ray?? kar????t??rmayal??m

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children(".anketGroupHeadCoveragerHeader").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children(".anketGroupHeadCoveragerHeadText").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor oldu??unu g??rd??k

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".anketSeceneklerIcAlan").children(".anketGroupOptions").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu y??zden yeniden foreach yap??s??na tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){

                var anketSoru               = $(value).children(".anketSoru").children(".anketSoruVal").val();
                var anketSoruZorunluluk     = $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin i??indeki veriyi temizlememek gerekti??inden temizledik.
            soruList        = {}; // Listelerin i??indeki veriyi temizlememek gerekti??inden temizledik.
        });

        gelenAnketBilgisi = $("body").attr("name");
        var confirmResult = confirm("Veri g??ncelleme i??lemi yapt??????n??zda anketinize verilen cevaplar silineceketir. (Anket ba??l?????? de??i??tirme gibi fakt??rler bu silinme i??lemine dahil de??ildir.)");
        if(confirmResult){
            $.post(base_url + '/ownerController/anketUpdate/' + gelenAnketBilgisi, {queryName: temelAnketVerileri,queryString: UstList}, function(data)
            {
            if(data.length > 0)
            {
                history.back();
            }
            });
        }else{
            $(".veriGuncelle").prop( "disabled", false);
            return $(".veriGuncelle").html(OncekiHal);
        }
    });
});