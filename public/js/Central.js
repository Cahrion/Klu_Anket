function anketIcerigiEkle(node){
    $(node).css("display", "none");
    $(node).siblings("span").css("display", "none");
    var html = `
        <div class="anketCoverager">
            <div class="baslik">
                <input type="text" placeholder="Soru Başlığı">
            </div>
            <div class="anketSorular row">
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
        <div class="anketSorular row">
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
                <div class="anketSorular row">
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