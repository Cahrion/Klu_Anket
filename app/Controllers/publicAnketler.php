<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AyarModel;
use App\Models\IslemModel;

\Config\Services::session();

class publicAnketler extends Controller
{
    public function Anketler($gelenLink = "")
    {
        helper("fonksiyonlar");
        if($gelenLink != ""){
            $gelenLinkExploded = explode("-",$gelenLink);
            if(count($gelenLinkExploded) > 1){
                $gelenLinkID = end($gelenLinkExploded); // SEO yapısına uygun yapıda "-" ayrılmış kısmın son hanesinde ID değeri olur.
                $Islem  = new IslemModel();
                if($gelenAnket = $Islem->getAnketProject($gelenLinkID)){ // Anketin varlığını sorguladık.

                    $resultLink = SEO($gelenAnket->baslik,$gelenAnket->id); // Yapının olması gereken SEO halini sorguladık.
                    if($gelenLink == $resultLink){ // Aynı ise siteyi gösterdik.
                        $Ayar  = new AyarModel();
                        $data = array(
                            "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                            "anketKaydi" => $gelenAnket
                        );
                        return view('public/publicAnketler', $data);
                    }
                }
            }
        }
        echo "Böyle bir anketimiz bulunmamaktadır.";
        die();
    }
}
