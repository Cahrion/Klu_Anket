<link rel="stylesheet" href="<?php echo base_url("css/navbar_kontrol.css");?>">
<nav id="baslik" class='navbar navbar-expand-md navbar-dark shadow bg-dark'>
    <a href=<?php echo base_url("OwnerController/adminAnket");?> id="DisLogo" class="topLogo"><img src="<?php echo base_url("img/kluLogo.png");?>" alt="KluLogo" title="KluLogo" style="padding-left: 50px;"></a>
    <div class='container'>
    <a href=<?php echo base_url("OwnerController/adminAnket");?> id="IcLogo" class="topLogo"><img src="<?php echo base_url("img/kluLogo.png");?>" alt="KluLogo" title="KluLogo"></a>
        <div class='text-right'>
            <ul class='navbar-nav'>
                    <li class='nav-item text-muted'>
                        <a href="<?php echo base_url("/OwnerController") ?>" class='navbar_options text-muted'>
                            Anket Oluştur
                        </a>          
                    </li> 
                    <li class='nav-item'>
                        <a href="<?php echo base_url("OwnerController/adminAnket")?>" class='navbar_options text-muted'>
                            Anketlerim
                        </a>          
                    </li>   
                <?php
                if($yonetimBilgi->yonetimFaktoru){
                ?>
                    <li class='nav-item'>
                        <a href="<?php echo base_url("AdminController");?>" class='navbar_options text-muted'>
                            Yönetici Ekle 
                        </a>          
                    </li>   
                    <li class='nav-item'>
                        <a href="<?php echo base_url("OwnerController/anketler");?>" class='navbar_options text-muted'>
                            Bütün Anketler
                        </a>          
                    </li>  
                <?php
                }
                ?>
                    <li class='nav-item'>
                        <a href="<?php echo base_url("OwnerController/leave");?>" class='navbar_options text-muted'>
                            Çıkış Yap
                        </a>          
                    </li>
            </ul>  
        </div>      
    </div>
</nav> 