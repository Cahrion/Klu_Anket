function anketIcerigiEkle(node){
    $(node).css("display", "none");
    $(node).siblings("span").css("display", "none");
    var myColor = $(node).parent().siblings(".anketGroupHeadCoverager").children(".renkAlani").css("background-color");
    var html = `
        <div class="anketCoverager" style="border-left: 4px solid ` + myColor + `">
            <div class="anketSoru">
                <input type="text" placeholder="Soru">
            </div>
            <div class="row mt-5">
                <div class="col-6 col-md-8 col-xl-9"></div>
                <div class="col-6 col-md-4 col-xl-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="anketSoruZorunluluk" onclick='zorunlulukFaktor(this)' checked>
                        <label class="form-check-label" for="flexSwitchCheckDefault" style="color:red;font-weight:bold">Zorunlu</label>
                    </div>
                </div>
            </div>
            <!-- Kullanıcı soru ekleme alanı -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
        </div>
    `;
    $(node).parent().parent().append(html);
}
function soruSecenekEkle(node){
    $(node).css("display", "none");
    var html = `
        <div class="anketSecenekler row">
            <div class="col-10">
                <input type="text" placeholder="Seçenekler">
            </div>
            <!-- Kullanıcı şık ekleme alanı -->
            <div class="col-2 text-center">
                <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
            </div>
        </div>
    `;
    $(node).parent().parent().parent().append(html);
}
function anketGroupEkle(node){
    var html = `
        <div class="GroupCoverager mt-4">
            <div class="anketGroupHeadCoverager">
                <div class="renkAlani" onclick='renkAlani(this)'></div>
                <div class="baslik">
                    <input type="text" value="Group Başlığı">
                </div>
                <div class="baslikMetni">
                    <textarea class="text-muted" cols="30" rows="10">Detay bilgisini giriniz</textarea>
                </div>
                <div class="anketSecenekler row">
                    <div class="col-10">
                        <input type="text" placeholder="Seçenekler">
                    </div>
                    <!-- Kullanıcı şık ekleme alanı -->
                    <div class="col-2 text-center">
                        <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
                    </div>
                </div>
            </div>
            <div class="anketCoverager">
                <div class="anketSoru">
                    <input type="text" placeholder="Soru">
                </div>
                <div class="row mt-5">
                    <div class="col-6 col-md-8 col-xl-9"></div>
                    <div class="col-6 col-md-4 col-xl-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="anketSoruZorunluluk" onclick='zorunlulukFaktor(this)' checked >
                            <label class="form-check-label" for="flexSwitchCheckDefault" style="color:red;font-weight:bold">Zorunlu</label>
                        </div>
                    </div>
                </div>
                <!-- Kullanıcı soru ekleme alanı -->
                <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
                <span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
            </div>
        </div>
    `;
    $(".anketPlatform").append(html);
}
function renkAlani(node){
    var renkler = ["rgb(0, 0, 0)", "rgb(0, 0, 255)","rgb(255, 0, 255)","cyan", "rgb(0, 224, 0)", "rgb(160, 0, 255)", "rgb(255, 255, 0)"];
    var renk = $(node).css("background-color");
    var index = $.inArray(renk, renkler);
    $(node).css("background-color", renkler[index + 1]);
    $(node).parent().siblings().css("border-left", "4px solid " + renkler[index + 1])
}
function zorunlulukFaktor(node){
    if($(node).prop("checked")){
        $(node).siblings("label").css("color","red");
        $(node).siblings("label").text("Zorunlu");
    }else{
        $(node).siblings("label").css("color","green");
        $(node).siblings("label").text("Serbest");
    }
}

$(document).ready(function(){
    // Gelen bir çok veriye karşılık bulabilmek amacıyla foreach yapısından gelen verileri alıyor ve bunlar serialize ederek sisteme eklemeye çalışıyoruz
    $("#veriGonder").click(function(){
        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var secenekList = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var soruList    = {};  // Liste ataması kullanarak sırayı karıştırmayalım

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children("input").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children("textarea").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor olduğunu gördük

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".col-10").children("input").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){
                
                var anketSoru               = $(value).children(".anketSoru").children("input").val();
                var anketSoruZorunluluk     = $(value).children(".row").children(".col-xl-3").children(".form-check").children("input").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
            soruList        = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
        });
        
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children("input").val(); // Anket Başlığı
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children("textarea").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children("textarea").val(); // Anket Açıklama Metni
        

        $.post(window.location.href + '/anketAdd', {queryName: [anketBaslik,anketBaslikM,anketBaslikA],queryString: UstList}, function(data) 
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
        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var secenekList = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var soruList    = {};  // Liste ataması kullanarak sırayı karıştırmayalım

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children("input").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children("textarea").val();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor olduğunu gördük

            var groupElementSecenekler      = $(groupElement).children(".anketSecenekler");
            $.each(groupElementSecenekler, function(key, value){
                var anketSecenek            = $(value).children(".col-10").children("input").val();
                secenekList[key]            = anketSecenek;
            });

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){
                var anketSoru               = $(value).children(".anketSoru").children("input").val();
                var anketSoruZorunluluk     = $(value).children(".row").children(".col-xl-3").children(".form-check").children("input").prop("checked");
                soruList[key]               = [anketSoru,anketSoruZorunluluk];
            });
            var Iclist      = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key]    = [Iclist, secenekList, soruList] // Ekliyoruz
            secenekList     = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
            soruList        = {}; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
        });
        
        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children("input").val(); // Anket Başlığı
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children("textarea").val(); // Anket Metni
        var anketBaslikA    = $(".anketHeadCoverager").children(".aciklamaMetni").children("textarea").val(); // Anket Açıklama Metni
        var anketID         = $(".anketHeadCoverager").attr("id"); // Anket Metni
        
        // Konum verisini sürekli olarak buradan değiştirmek yerine bağlantı kısmından istenilen konumu aldım. (ownerController/anketUpdate)
        var pathKonum          = window.location.pathname.split("/");
        var originKonum        = window.location.origin; 
        var needKonum          = originKonum +  "/" + pathKonum[1] + "/" + pathKonum[2] + "/" + pathKonum[3];

        $.post(needKonum + '/anketUpdate', {queryName: [anketBaslik,anketBaslikM,anketBaslikA,anketID],queryString: UstList}, function(data) 
        {
        if(data.length > 0)
        {
            window.location.href = needKonum + '/adminAnket';
        }
        });
        
    });
});
