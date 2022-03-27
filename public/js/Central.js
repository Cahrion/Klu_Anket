function anketIcerigiEkle(node){
    $(node).css("display", "none");
    $(node).siblings("span").css("display", "none");
    var html = `
        <div class="anketCoverager">
            <div class="baslik">
                <input type="text" placeholder="Soru Başlığı">
            </div>
            <div class="anketSecenekler row">
                <div class="col-10">
                    <input type="text" placeholder="Şıklar">
                </div>
                <!-- Kullanıcı şık ekleme alanı -->
                <div class="col-2 text-center">
                    <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
                </div>
            </div>
            <!-- Kullanıcı soru ekleme alanı -->
            <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
            <span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
            <!-- 
            <span class="anketIcerigiEkle"></span> -->
        </div>
    `;
    $(node).parent().parent().append(html);
}
function soruSecenekEkle(node){
    $(node).css("display", "none");
    var html = `
        <div class="anketSecenekler row">
            <div class="col-10">
                <input type="text" placeholder="Şıklar">
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
            </div>
            <div class="anketCoverager">
                <div class="baslik">
                    <input type="text" placeholder="Soru Başlığı">
                </div>
                <div class="anketSecenekler row">
                    <div class="col-10">
                        <input type="text" placeholder="Şıklar">
                    </div>
                    <!-- Kullanıcı şık ekleme alanı -->
                    <div class="col-2 text-center">
                        <button class="btn btn-primary soruSecenekEkle" onclick="soruSecenekEkle(this)">+</button>
                    </div>
                </div>
                <!-- Kullanıcı soru ekleme alanı -->
                <span class="anketIcerigiEkle" onclick="anketIcerigiEkle(this)"> S </span>
                <span class="anketGroupEkle" onclick="anketGroupEkle(this)"> G </span>
                <!-- 
                <span class="anketIcerigiEkle"></span> -->
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

$(document).ready(function(){
    // Gelen bir çok veriye karşılık bulabilmek amacıyla foreach yapısından gelen verileri alıyor ve bunlar serialize ederek sisteme eklemeye çalışıyoruz
    $("#veriGonder").click(function(){
        var UstGrup     = $(".GroupCoverager");
        var UstList     = {};   // Liste ataması kullanarak sırayı karıştırmayalım
        var OrtaList    = {};  // Liste ataması kullanarak sırayı karıştırmayalım
        var AltList     = {};   // Liste ataması kullanarak sırayı karıştırmayalım

        $.each(UstGrup, function(key, value){
            var groupElement                = $(value).children(".anketGroupHeadCoverager");
            var groupElementRenk            = $(groupElement).children(".renkAlani").css("background-color");
            var groupElementBaslik          = $(groupElement).children(".baslik").children("input").val();
            var groupElementbaslikMetni     = $(groupElement).children(".baslikMetni").children("textarea").text();
            // document.write(groupElementRenk + "<br>" + groupElementBaslik + "<br>" + groupElementbaslikMetni); // Denedik ve geliyor olduğunu gördük

            var groupAnketGroup             = $(value).children(".anketCoverager"); // Birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
            $.each(groupAnketGroup, function(key, value){
                var anketSoruBaslik         = $(value).children(".baslik").children("input").val();

                var anketSoruSecenek        = $(value).children(".anketSecenekler") // Yine birden fazla olabilir bu yüzden yeniden foreach yapısına tabi tutuyoruz
                $.each(anketSoruSecenek, function(key, value){
                    var SecenekVerisi       = $(value).children(".col-10").children("input").val();
                    AltList[key] = SecenekVerisi; // Ekleme işlemine küçük veriden başlıyoruz.
                });
                OrtaList[key] = [anketSoruBaslik, AltList]; // Ekliyoruz
                AltList = []; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
            });
            var Iclist = [groupElementRenk, groupElementBaslik, groupElementbaslikMetni];
            UstList[key] = [Iclist, OrtaList] // Ekliyoruz
            OrtaList = []; // Listelerin içindeki veriyi temizlememek gerektiğinden temizledik.
        });
        // document.write(UstList); // Verimiz UstList dosyasına başarıyla eklendi. (Veriler bu metodla görülebilir.)
        // $.each(UstList, function(key, value){
        //     document.write(value + "<br>");
        //     $.each(value[1], function(key, value){
        //         document.write(value + "<br>");
        //         $.each(value[1], function(key, value){
        //             document.write(value + "<br>");
        //         });
        //     });
        // });
        
        // Veriyi bir php dosyasına gönderiyoruz. ( Mola )
        // Post yapısı çalışmadı (Biraz mola vermeye karar verdim)

        var anketBaslik     = $(".anketHeadCoverager").children(".baslik").children("input").val(); // Anket Başlığı
        var anketBaslikM    = $(".anketHeadCoverager").children(".baslikMetni").children("textarea").text(); // Anket Metni

        $.post(window.location.href + '/anketAdd', {queryName: [anketBaslik,anketBaslikM],queryString: UstList}, function(data) 
        {
        if(data.length > 0)
        {
            document.write(data);
        }
        });
        
        
    });
});