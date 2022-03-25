<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use App\Models\IslemModel;
use App\Models\AyarModel;

// Database işlemlerinin hepsini yapmak için kullanılan yazılım alanı

class Data extends Controller
{
    // Normal halde giriş yapmak için kullanılan yapı bulunmakta
    public function index()
    {
        $Ayar   = new AyarModel();
        helper("fonksiyonlar");
        if(isset($_POST["email"])){
            $gelenEmail = GuvenlikFiltresi($_POST["email"]);
        }else{
            $gelenEmail = "";
        }
        if(isset($_POST["password"])){
            $gelenPassword = GuvenlikFiltresi($_POST["password"]);
        }else{
            $gelenPassword = "";
        }
        if($gelenEmail != "" and $gelenPassword != ""){
            $CtrlM  = new IslemModel();
            
            if($CtrlM->getControlMembers($gelenEmail)){
                $_SESSION["Yonetici"]	=	$gelenEmail;
                // Buralarda CURL bağlantısıyla true geldiğini varsayıyorum ve yeni sayfaya aktarıyorum.
                // Şifre yapıları elimizde olmayacağından dolayı veritabanında da sadece email adresi bıraktım.

            }else{
                // İletişime Geçin Sayfasına Yönlendirilicek.
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/Home/Iletisim");
                exit();
            }
        }else{
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
}
