<?php

namespace App\Controllers;
\Config\Services::session();

class Home extends BaseController
{
    public function index()
    {
        if(!isset($_SESSION["Yonetici"])){
            $data = array(
                "klu_bilgi" => "yn_giris"
            );
            return view('welcome',$data);
        }else{
            header("Location: " . base_url("ownerController/adminAnket"));
            exit();
        }
    }
    public function giris()
    {
        if(!isset($_SESSION["Yonetici"])){
            $data = array(
                "klu_bilgi" => "klu_giris"
            );
            return view('welcome', $data);
        }else{
            header("Location: " . base_url("ownerController/adminAnket"));
            exit();
        }
    }
    public function Iletisim(){
        return view('iletisim');
    }
}
