<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AyarModel;
\Config\Services::session();

class ownerController extends Controller
{
    // Ana yapıda sitenin merkez kısmına erişimi koydum kişi buradan öncelikle anket ekleme bölümüne giriş yapar.
    public function index()
    {
        $Ayar  = new AyarModel();
        if(isset($_SESSION["Yonetici"])){
            $data = array(
                "SiteLinki" => $Ayar->get_Ayars("SiteLinki")
            );
            return view('Central', $data);
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
