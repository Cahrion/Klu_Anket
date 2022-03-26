function anketIcerigiEkle(node){
    $(node).css("display", "none");
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
            <span class="anketIcerigiEkle" onclick='anketIcerigiEkle(this)'> + </span>
            <!-- 
            <span class="anketIcerigiEkle"></span>
            <span class="anketIcerigiEkle"></span> -->
        </div>
    `;
    $(".anketPlatform").append(html);
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
$(document).ready(function(){
    $(".renkAlani").click(function(){
        var renkler = ["rgb(0, 0, 0)", "rgb(0, 0, 255)","rgb(255, 0, 255)","cyan", "rgb(0, 224, 0)", "rgb(160, 0, 255)", "rgb(255, 255, 0)"];
        var renk = $(this).css("background-color");
        var index = $.inArray(renk, renkler);
        $(this).css("background-color", renkler[index + 1]);
        $(this).parent().siblings().css("border-left", "4px solid " + renkler[index + 1])
    });
});