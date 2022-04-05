var base_url = $("base").attr("href");
function anketIcerigiEkle(node){
    $(node).css("display", "none");
    $(node).siblings(".anketGroupEkle").css("display", "none");
    var myColor = $(node).parent().siblings(".anketGroupHeadCoverager").children(".renkAlani").css("background-color");
    var html = `
        <div class="anketCoverager" style="border-left: 4px solid ` + myColor + `">
            <div class="anketSoru">
                <input type="text" placeholder="Soru" class="anketSoruVal">
            </div>
            <div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
                <input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' checked>
                <label class="form-check-label" style="color:red;font-weight:bold">Zorunlu</label>
            </div>
            <!-- Kullanıcı soru ekleme alanı -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
            <span class="anketIcerigiSil" onclick="anketIcerigiSil(this)">Soru Sil</span>
        </div>
    `;
    $(node).parent().parent().append(html);
}
function soruSecenekEkle(node){
    $(node).css("display", "none");
    var html = `
        <div class="anketSecenekler row">
            <div class="col-10 anketSeceneklerIcAlan">
                <input type="text" placeholder="Seçenekler" class="anketGroupOptions">
            </div>
            <!-- Kullanıcı şık ekleme alanı -->
            <div class="col-2 text-center">
                <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
            </div>
        </div>
    `;
    $(node).parent().parent().parent().append(html);
}
function anketGroupEkle(node){
    var html = `
    <div class="GroupCoverager mt-4">
        <div class="anketGroupHeadCoverager">
            <span class="anketGroupSil" onclick="anketGroupSil(this)">Grup Sil</span>
            <div class="renkAlani" onclick='renkAlani(this)'></div>
            <div class="baslik">
                <input type="text" placeholder="Grup Başlığı" class="anketGroupHeadCoveragerHeader">
            </div>
            <div class="baslikMetni">
                <textarea class="text-muted" cols="30" rows="10" placeholder="Detay bilgisini giriniz" class="anketGroupHeadCoveragerHeadText"></textarea>
            </div>
            <div class="anketSecenekler row">
                <div class="col-10 anketSeceneklerIcAlan">
                    <input type="text" placeholder="Seçenekler" class="anketGroupOptions">
                </div>
                <!-- Kullanıcı şık ekleme alanı -->
                <div class="col-2 text-center">
                    <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)"><i class="fa-solid fa-plus"></i> </button>
                </div>
            </div>
        </div>
        <div class="anketCoverager">
            <div class="anketSoru">
                <input type="text" placeholder="Soru" class="anketSoruVal">
            </div>
            <div class="form-check form-switch mt-3 anketGroupcompulsory" style="float:right">
                <input class="form-check-input anketSoruZorunluluk" type="checkbox" onclick='zorunlulukFaktor(this)' checked>
                <label class="form-check-label" for="" style="color:red;font-weight:bold">Zorunlu</label>
            </div>
            <!-- Kullanıcı soru ekleme alanı -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
        </div>
    </div>
    `;
    $(".anketPlatform").append(html);
}
function anketGroupSil(node){
    $(node).parent().parent().remove();
}
function anketIcerigiSil(node){
    var html = `
        <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)">Soru Ekle</span>
        <span class="anketGroupEkle" onclick="anketGroupEkle(this)">Grup Ekle</span>
    `;
    $(node).parent().prev().append(html);
    $(node).parent().remove();
}
function renkAlani(node){
    var renkler = ["rgb(0, 0, 0)", "rgb(234, 228, 135)","rgb(168, 234, 135)","rgb(234, 144, 135)", "rgb(135, 234, 193)", "rgb(126, 189, 255)"];
    var renk = $(node).css("background-color");
    var index = $.inArray(renk, renkler);
    if(index == renkler.length-1){
        index = -1;
    }
    $(node).css("background-color", renkler[index + 1]);
    $(node).parent().siblings().css("border-left", "4px solid " + renkler[index + 1])
}
function zorunlulukFaktor(node){
    if($(node).prop("checked")){
        $(node).siblings("label").css("color","red");
    }else{
        $(node).siblings("label").css("color","green");
    }
}
function anketGirisZorunluluk(node){
    if($(node).prop("checked")){
        $(node).siblings("label").css("color","red");
    }else{
        $(node).siblings("label").css("color","green");
    }
}


$(document).ready(function(){
    // Gelen bir çok veriye karşılık bulabilmek amacıyla foreach yapısından gelen verileri alıyor ve bunlar serialize ederek sisteme eklemeye çalışıyoruz
    $("#veriGonder").click(function(){
        
        // Üst anket verilerin alımı.
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children(".anketHeadCoveragerHeader").val(); // Anket Başlığı
        if(anketBaslik == ""){
            alert("Lütfen başlık kısmını doldurunuz.");
            $(".anketHeadCoverager").children(".baslik").children("input").focus();
            return $(".anketHeadCoverager").children(".baslik").children("input").attr("placeholder", "Burası boş geçilemez.");
        }
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children(".anketHeadCoveragerHeadText").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children(".anketHeadCoveragerExplanationText").val(); // Anket Açıklama Metni
        var anketKitle      = $("#formKitleSelected").val();
        var anketGiris      = $("#anketGirisZorunluluk").prop("checked"); // Anket Giriş
        
        if(anketKitle == ""){
            alert("Lütfen hitap edilen kitleyi seçiniz.");
            return $("#formKitleSelected").focus();;
        }
        if(anketGiris){
            anketGiris = 1;
        }else{
            anketGiris = 0;
        }
        
        var temelAnketVerileri = [anketBaslik,anketBaslikM,anketBaslikA,anketKitle,anketGiris];

        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var secenekList = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var soruList    = {};  // Liste ataması kullanarak sırayı karıştırmayalım

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children(".anketGroupHeadCoveragerHeader").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children(".anketGroupHeadCoveragerHeadText").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor olduğunu gördük

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".anketSeceneklerIcAlan").children(".anketGroupOptions").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){
                
                var anketSoru               = $(value).children(".anketSoru").children(".anketSoruVal").val();
                var anketSoruZorunluluk     = $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
            soruList        = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
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
    // Gelen bir çok veriye karşılık bulabilmek amacıyla foreach yapısından gelen verileri alıyor ve bunlar serialize ederek sisteme eklemeye çalışıyoruz
    $("#veriGuncelle").click(function(){

        // Üst anket verilerin alımı.
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children(".anketHeadCoveragerHeader").val(); // Anket Başlığı
        if(anketBaslik == ""){
            alert("Lütfen başlık kısmını doldurunuz.");
            $(".anketHeadCoverager").children(".baslik").children("input").focus();
            return $(".anketHeadCoverager").children(".baslik").children("input").attr("placeholder", "Burası boş geçilemez.");
        }
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children(".anketHeadCoveragerHeadText").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children(".anketHeadCoveragerExplanationText").val(); // Anket Açıklama Metni
        var anketKitle      = $("#formKitleSelected").val();
        var anketGiris      = $("#anketGirisZorunluluk").prop("checked"); // Anket Giriş
        var anketID         = $(".anketHeadCoverager").attr("id"); // Anket Metni
        if(anketKitle == ""){
            alert("Lütfen hitap edilen kitleyi seçiniz.");
            return $("#formKitleSelected").focus();;
        }
        if(anketGiris){
            anketGiris = 1;
        }else{
            anketGiris = 0;
        }
        var temelAnketVerileri = [anketBaslik,anketBaslikM,anketBaslikA,anketKitle,anketGiris,anketID];

        // Anket içinin verilerinin alımı.
        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var secenekList = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var soruList    = {};  // Liste ataması kullanarak sırayı karıştırmayalım

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children(".anketGroupHeadCoveragerHeader").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children(".anketGroupHeadCoveragerHeadText").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor olduğunu gördük

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".anketSeceneklerIcAlan").children(".anketGroupOptions").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){
                
                var anketSoru               = $(value).children(".anketSoru").children(".anketSoruVal").val();
                var anketSoruZorunluluk     = $(value).children(".anketGroupcompulsory").children(".anketSoruZorunluluk").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
            soruList        = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
        });
        
        $.post(base_url + '/ownerController/anketUpdate', {queryName: temelAnketVerileri,queryString: UstList}, function(data) 
        {
        if(data.length > 0)
        {
            history.back();
        }
        });
        
    });
});
