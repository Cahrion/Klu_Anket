<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use App\Models\IslemModel;
\Config\Services::session();
// Database işlemlerinin hepsini yapmak için kullanılan yazılım alanı

class Data extends Controller
{
    // Normal halde giriş yapmak için kullanılan yapı bulunmakta
    public function index()
    {
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
            
            if($CtrlM->getControlMember($gelenEmail)){
                
                $_SESSION["Yonetici"]	=	$gelenEmail;
                // Buralarda CURL bağlantısıyla true geldiğini varsayıyorum ve yeni sayfaya aktarıyorum.
                // Şifre yapıları elimizde olmayacağından dolayı veritabanında da sadece email adresi bıraktım.
                header("Location: " . base_url("ownerController/adminAnket"));
                exit();

            }else{
                // İletişime Geçin Sayfasına Yönlendirilicek.
                header("Location: " . base_url("Home/Iletisim"));
                exit();
            }
        }else{
            header("Location: " . base_url());
            exit();
        }
    }
}
