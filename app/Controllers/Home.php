<?php

namespace App\Controllers;
\Config\Services::session();

class Home extends BaseController
{
    public function index()
    {
        if(!isset($_SESSION["Yonetici"])){
            return view('welcome');
        }else{
            header("Location: " . base_url("ownerController/adminAnket"));
            exit();
        }
    }
    public function Iletisim(){
        return view('iletisim');
    }
}
