<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AyarModel;
use App\Models\IslemModel;
\Config\Services::session();

class ownerController extends Controller
{
    // Ana yapıda sitenin merkez kısmına erişimi koydum kişi buradan öncelikle anket ekleme bölümüne giriş yapar.
    public function index()
    {
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if(isset($_SESSION["Yonetici"])){
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $data = array(
                "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                "yonetimBilgi" => $Islem->getControlMember($_SESSION["Yonetici"])
            );
            return view('Central', $data);
        }else{
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    // Admin silme, ekleme ve güncelleme işlemlerini burada yapar.
    public function adminPanel()
    {
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if(isset($_SESSION["Yonetici"])){
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if($yonetimBilgi->yonetimFaktoru){
                $data = array(
                    "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                    "yonetimBilgi" => $yonetimBilgi,
                    "yoneticilerBilgi" => $Islem->getControlMembers()
                );
                return view('adminPanel', $data);
            }else{
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        }else{
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
        // Çıkış yapma yapısı
    public function leave(){
        $Ayar  = new AyarModel();
        unset($_SESSION["Yonetici"]);
        session_destroy();
        
        header("Location: " . $Ayar->get_Ayars("SiteLinki") ."public");
        exit();
    }
}
