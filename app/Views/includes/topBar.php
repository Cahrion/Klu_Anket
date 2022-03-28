<link rel="stylesheet" href="<?php echo $SiteLinki . "public/css";?>/navbar_kontrol.css">
<nav id="baslik" class='navbar navbar-expand-md navbar-dark shadow bg-dark'>
    <a href=<?php echo $SiteLinki . "public/img/kluLogo.jpg";?> id="DisLogo" class="topLogo"><img src="<?php echo $SiteLinki . "public/img/kluLogo.jpg";?>" alt="KluLogo" title="KluLogo" style="padding-left: 50px;"></a>
    <div class='container'>
    <a href=<?php echo $SiteLinki . "public/img/kluLogo.jpg";?> id="IcLogo" class="topLogo"><img src="<?php echo $SiteLinki . "public/img/kluLogo.jpg";?>" alt="KluLogo" title="KluLogo"></a>
        <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#collapsibleNavbar' style="background-color: white;">
            <span class="navbar-toggler-icon bg-secondary"></span>
        </button>
        <div class='collapse navbar-collapse text-right' id='collapsibleNavbar'>
            <ul class='navbar-nav'>
                    <li class='nav-item text-muted'>
                        <a href="<?php echo $SiteLinki . "public/ownerController"?>" class='navbar_options text-muted'>
                            Anket Oluştur
                        </a>          
                    </li> 
                    <li class='nav-item'>
                        <a href="<?php echo $SiteLinki . "public/ownerController/adminAnket"?>" class='navbar_options text-muted'>
                            Anketlerim
                        </a>          
                    </li>   
                <?php
                if($yonetimBilgi->yonetimFaktoru){
                ?>
                    <li class='nav-item'>
                        <a href="<?php echo $SiteLinki . "public/adminController"?>" class='navbar_options text-muted'>
                            Yönetici Ekle 
                        </a>          
                    </li>   
                    <li class='nav-item'>
                        <a href="<?php echo $SiteLinki . "public/ownerController/anketler"?>" class='navbar_options text-muted'>
                            Bütün Anketler
                        </a>          
                    </li>  
                <?php
                }
                ?>
                    <li class='nav-item'>
                        <a href="<?php echo $SiteLinki . "public/ownerController/leave"?>" class='navbar_options text-muted'>
                            Çıkış Yap
                        </a>          
                    </li>
            </ul>  
        </div>      
    </div>
</nav> 