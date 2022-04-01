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
                        if(isset($_SESSION["Yonetici"])){
                            $yonetimBilgi       = $Islem->getControlMember($_SESSION["Yonetici"]);
                            $yonetimFaktoru     = $yonetimBilgi->yonetimFaktoru;
                        }else{
                            $yonetimFaktoru = 0;
                        }
                        if($gelenAnket->onay or $yonetimFaktoru){
                            if($gelenAnket->anketGiris){ 
                                if(!isset($_SESSION["Yonetici"])){
                                    $Ayar = new AyarModel();
                                    echo "<script>alert('Anketimize katılmak için öncelikle üye girişi yapınız.');</script>"; // Aynı IP adresli veriyi direkt olarak klu adresine yolluyor.
                                    
                                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
                                    exit();
                                }
                            }
                            $Ayar  = new AyarModel();
                            $gelenIP = $_SERVER["REMOTE_ADDR"];
                            // if(!$Islem->getAnketIpReport($gelenAnket->id,$gelenIP)){ // Şimdilik kapatıyorum (Sisteme ait verileri düzeltince ve yayınlayınca açılacak.)
                                $data = array(
                                    "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                                    "anketKaydi" => $gelenAnket
                                );
                                return view('public/publicAnketler', $data);
                            // }else{
                            //     echo "<script>alert('Anketimize zaten önceden katılmıştınız...')</script>"; // Aynı IP adresli veriyi direkt olarak klu adresine yolluyor.
                            //     header("Location: https://www.klu.edu.tr/");
                            //     exit();
                            // }
                        }
                    }
                }
            }
        }
        echo "Böyle bir anketimiz bulunmamaktadır.";
        die();
    }
    public function anketLoading($gelenAnketID = ""){
        helper("fonksiyonlar");
        $Islem  = new IslemModel();
        if (isset($_POST["queryString"])) {
            $gelenQuery = $_POST["queryString"];
        } else {
            $gelenQuery = "";
        }
        if($gelenAnketID != ""){
            $anketID    = GuvenlikFiltresi($gelenAnketID);
        }else{
            $anketID    = "";
        }
        // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        if ($gelenQuery != "" and $anketID != "") {
            $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 
            $gelenIp            = $_SERVER["REMOTE_ADDR"]; // IP adresini yeniden cevap vermesini engellemek için tutalım.

            $Islem->setAnketResult($anketID, $gelenSerialize, $gelenIp); 

            echo "Onaylandı."; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
        } else {
            // Eğer ki verisel bir hata olursa kişiyi KLU sitesine atalım.
            header("Location: https://www.klu.edu.tr/");
            exit();
        }
    }
}
