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
    public function anketAdd(){
        $Ayar  = new AyarModel();
        if(isset($_SESSION["Yonetici"])){
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            if($_POST["queryString"]){
                $gelenQuery = $_POST["queryString"];
            }else{
                $gelenQuery = "";
            }
            if($gelenQuery != ""){
                echo $gelenQuery;
                die();
            }else{
                header("Location: " . $Ayar->get_Ayars("SiteLinki") ."public/ownerController");
                exit();
            }
        }else{
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }

    public function myAnket(){

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
