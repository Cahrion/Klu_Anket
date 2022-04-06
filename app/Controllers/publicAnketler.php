<?php

namespace App\Controllers;

use CodeIgniter\Controller;
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
                                if(!(isset($_SESSION["Yonetici"]) or isset($_SESSION["Kullanici"]))){
                                    echo "<script>alert('Anketimize katılmak için öncelikle üye girişi yapınız.');</script>"; // Aynı IP adresli veriyi direkt olarak klu adresine yolluyor.
                                    
                                    header("Location: " . base_url("Home/giris"));
                                    exit();
                                }
                            }
                            $gelenIP = $_SERVER["REMOTE_ADDR"];
                            // if(!$Islem->getAnketIpReport($gelenAnket->id,$gelenIP)){ // Şimdilik kapatıyorum (Sisteme ait verileri düzeltince ve yayınlayınca açılacak.)
                                $data = array(
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
        // Brans verilerinin alımı
        // Eğer ki gelen verilerde kişinin bransı "idari" ise otomatikmen birimID değeri 0 olur.

        if (isset($_POST["queryBrans"])) {
            $gelenQueryBrans = [];
            foreach($_POST["queryBrans"] as $keyV => $gelenQueryBransV){
                if($gelenQueryBransV == ""){ 
                    if($keyV != 2){ // Birim verisi ise
                        echo "3"; // Brans hatası .
                        exit();
                    }else{
                        if(!($gelenQueryBrans[0] == "idari" or $gelenQueryBrans[0] == "herkes")){ // idari verilerin birim verileri olmayacağından dolayı geçebilir.
                            echo "3"; // Brans hatası .
                            exit();
                        }
                    }
                }
                $gelenQueryBrans[] = GuvenlikFiltresi($gelenQueryBransV);
            }
        } else {
            $gelenQueryBrans = "";
        }
        // Güvenlik bilgilerinin alımı
        if(isset($_SESSION["guvenlikProtocolu"])){
            $gelenGuvenlikProtocol = GuvenlikFiltresi($_SESSION["guvenlikProtocolu"]); // Gelen gizli protocol verisini aldık.
            if($_POST["queryProtocol"]){
                $gelenQueryProtocol = GuvenlikFiltresi($_POST["queryProtocol"]); // Gelen protocol verisini aldık.
                if($gelenQueryProtocol == $gelenGuvenlikProtocol){ // Eşitse bir karakter bahşettik.
                    $gelenGuvenlikProtocol = "*";
                }
            }
        }else{
            $gelenGuvenlikProtocol = "";
        }
        if($gelenGuvenlikProtocol != "*"){ // Protocol koruması
            echo "2"; // Protocol hatası .
            exit();
        }


        // Anket bilgilerinini alımı
        if (isset($_POST["queryString"])) {
            $gelenQuery = [];
            foreach($_POST["queryString"] as $groupKey => $groupSoru){
                foreach($groupSoru as $groupSoruKey => $groupSoruCevap){
                    $gelenQuery[$groupKey][$groupSoruKey] = GuvenlikFiltresi($groupSoruCevap); // Tek tek guvenlik filtresinden geçirdik.
                }
            }
        } else {
            $gelenQuery = "";
        }
        // Anket ID değerinin alımı
        if($gelenAnketID != ""){
            $anketID    = GuvenlikFiltresi($gelenAnketID);
        }else{
            $anketID    = "";
        }

        if ($gelenQuery != "" and $anketID != "") {
            // Frontend kısımda eğğer bir hile yapılmayı çalışıp gerekli kısımlar gelmemişse burada yeniden kontrol ederek frontend kısma gönderiyoruz.

            $anketBilgisi       = $Islem->getAnketProject($anketID);
            $anketBilgisiSer    = unserialize($anketBilgisi->serialize);
            $zorunluAlan = [];
            foreach($anketBilgisiSer as $keyGroup => $anketBilgisiSerGroup){
                foreach($anketBilgisiSerGroup[2] as $keySoru => $anketBilgisiSerSorular){ // Kesin dolması gereken kısımları alıyoruz.
                    if($anketBilgisiSerSorular[1] == "true"){
                        $zorunluAlan[] = $keyGroup . "-" . $keySoru;
                    }
                }
            }
            // gelenQuery
            $hata = 0;
            foreach($gelenQuery as $groupKey => $groupSoru){ // Soru cevap grouplarını çekiyoruz.
                foreach($groupSoru as $groupSoruKey => $groupSoruCevap){ // Cevapların soru kısımlarını alıyoruz (Cevap verilmiş mi diye)
                    foreach($zorunluAlan as $zorunluAlanSoru){
                        $zorunluAlanExplode         = explode("-",$zorunluAlanSoru);
                        $zorunluAlanExplodeGroup    = $zorunluAlanExplode[0];
                        $zorunluAlanExplodeSoru     = $zorunluAlanExplode[1];
                        if($groupKey == $zorunluAlanExplodeGroup and $groupSoruKey == $zorunluAlanExplodeSoru){ 
                            // Group ve soru bilgisi eşit ise zorunlu sorulardan biri gelmiş demektir bunu hata kısmına ekleme yaparak yeniden döndürüyoruz.
                            $hata += 1;
                        }
                    }
                    $gelenQuery[$groupKey][$groupSoruKey] = GuvenlikFiltresi($groupSoruCevap); // Tek tek guvenlik filtresinden geçirdik.
                }
            }
            // gelenQuery
            if(count($zorunluAlan) != $hata){ // hata kısmında bir sıkıntı çıkmazsa kullanıcı gerekli kısımları doldurmuş demektir.
                echo "-1";
                exit();
            }else{
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 
                $gelenIp            = $_SERVER["REMOTE_ADDR"]; // IP adresini yeniden cevap vermesini engellemek için tutalım.
                // gelenQueryBrans[0] => Brans, gelenQueryBrans[1] => Fakulte, gelenQueryBrans[2] => Birim
                $Islem->setAnketResult($anketID, $gelenSerialize,$gelenQueryBrans[0], $gelenQueryBrans[1], $gelenQueryBrans[2], $gelenIp); 
    
                echo "1"; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
                exit();
            }
        } else {
            echo "0";
            exit();
        }
    }
    public function captchaCreator(){
        $metin = "";
		for($baslangic = 0;$baslangic <6;$baslangic++){
			$rastgeleSayi	    = mt_rand(48,57);
			$rastgeledeger	    = mt_rand(65,90);
            if(mt_rand(0,1)){
                $metin .= chr($rastgeledeger);
            }else{
                $metin .= chr($rastgeleSayi);
            }
		}
        $_SESSION["guvenlikProtocolu"] = $metin;
        echo $metin;
    }
}
