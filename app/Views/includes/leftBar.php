<style>
    .leftBarCoverager{
        transition: all 1s;
        font-size: large;
        font-weight: bold;
    }
    .leftBarCoverager:hover{
        border-radius: 100px;
        border-left: 50px;
        background-color: white;
        transform: translate(30px, -10px);
    }
    .leftBarCoverager a:link,.leftBarCoverager a:active,.leftBarCoverager a:visited{
        font-family: Arial, "Helvatica Neue", Helvatica, sans-serif;
        color: grey;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        text-decoration: none;
    }
    .leftBarCoverager a:hover{
        font-family: Arial, "Helvatica Neue", Helvatica, sans-serif;
        color: #646464;
        font-style: normal;
        font-variant: normal;
        font-weight: normal;
        text-decoration: none;
    }
    .leftBar{
        min-height: 890px;
    }
</style>
<!-- CSS dosyalarına erişimim nedense bozulduğundan dolayı şu anda style tağlarıyla erişim sağlıyorum ek bir düzeltme yapılacaktır. -->
<div class="w-100 bg-dark pt-5 leftBar">
    <div class="w-100 text-center pb-5">
        <img src="https://fakeimg.pl/350x200/" alt="KLU" title="KLU" class="w-50">
    </div> <!-- img -->
    <div class="text-center leftBarCoverager py-2 my-3">
        <a href="...">Yönetici Ekle</a>
    </div> <!-- icerikler --> 
    <div class="text-center leftBarCoverager py-2 my-3">
        <a href="...">Anket Ekle</a>
    </div> <!-- icerikler --> 
    <div class="text-center leftBarCoverager py-2 my-3">
        <a href="<?php echo $SiteLinki . "public/ownerController/leave"?>">Çıkış Yap</a>
    </div> <!-- icerikler --> 
</div>