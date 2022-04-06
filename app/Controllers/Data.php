<?php

namespace App\Controllers;

use \CodeIgniter\Controller;
use App\Models\IslemModel;
\Config\Services::session();
// Database işlemlerinin hepsini yapmak için kullanılan yazılım alanı

class Data extends Controller
{
    // Normal halde giriş yapmak için kullanılan yapı bulunmakta
    public function yn_giris()
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
    public function klu_giris() // Ogrenciler ve benzeri kişilerin giriş alanı
    {
        helper("fonksiyonlar");
        if(isset($_POST["gelenEmail"])){
            $gelenEmail = GuvenlikFiltresi($_POST["gelenEmail"]);
        }else{
            $gelenEmail = "";
        }
        if(isset($_POST["gelenPass"])){
            $gelenPassword = GuvenlikFiltresi($_POST["gelenPass"]);
        }else{
            $gelenPassword = "";
        }
        if($gelenEmail != "" and $gelenPassword != ""){
            
            $_SESSION["Kullanici"]	=	$gelenEmail; // Öğrenciler de bu sistemi kullanacağından dolayı eğer bir öğrenci girecekse kullanici sessionu'nu alsın
            // publicAnketler kısmında Hem kullanici hem de yönetici etiketlerine bakacağız bu yüzden ikisinden biri olması o siteye girmesi için yeterli olucaktır.

            // Buralarda CURL bağlantısıyla true geldiğini varsayıyorum ve yeni sayfaya aktarıyorum.
            // Şifre yapıları elimizde olmayacağından dolayı veritabanında da sadece email adresi bıraktım.
            
            echo "1"; // Başarılı
            exit();

        }else{
            echo "0";
            exit();
        }
    }
}
