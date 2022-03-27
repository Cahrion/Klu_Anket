<?php

namespace App\Controllers;
use App\Models\AyarModel;
\Config\Services::session();

class Home extends BaseController
{
    public function index()
    {
        $Ayar  = new AyarModel();
        if(!isset($_SESSION["Yonetici"])){
            $data = array(
                "SiteLinki" => $Ayar->get_Ayars("SiteLinki")
            );
            return view('welcome', $data);
        }else{
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
            exit();
        }
    }
    public function Iletisim(){
        $Ayar  = new AyarModel();
        $data = array(
            "SiteLinki" => $Ayar->get_Ayars("SiteLinki")
        );
        return view('iletisim', $data);
    }
}
