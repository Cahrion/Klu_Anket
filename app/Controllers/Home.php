<?php

namespace App\Controllers;
use App\Models\AyarModel;

class Home extends BaseController
{
    public function index()
    {
        $Ayar  = new AyarModel();
        $data = array(
            "SiteLinki" => $Ayar->get_Ayars("SiteLinki")
        );
        return view('welcome', $data);
    }
    public function Iletisim(){
        $Ayar  = new AyarModel();
        $data = array(
            "SiteLinki" => $Ayar->get_Ayars("SiteLinki")
        );
        return view('iletisim', $data);
    }
}
