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
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $data = array(
                "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                "yonetimBilgi" => $Islem->getControlMember($_SESSION["Yonetici"])
            );
            return view('Central', $data);
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function anketler(){
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                $data = array(
                    "SiteLinki"     => $Ayar->get_Ayars("SiteLinki"),
                    "yonetimBilgi"  => $yonetimBilgi,
                    "anketKayitlari" => $Islem->getAnketProjects()
                );
                return view('adminAnketler', $data);
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function anketOnay($gelenID = ""){ // Anketi onaylıyoruz veya onay kaldırıyoruz.

        helper("fonksiyonlar"); // Guvenlik filtresi fonksiyonunu kullanmak amaçlı
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) { // Yonetimini sorguladık.
                if($gelenID != ""){
                    $gelenID    = GuvenlikFiltresi($gelenID);
                    $gelenAnketVerisi = $Islem->getAnketProject($gelenID); // Anketi aldık.

                    $gelenTersOnay  = $gelenAnketVerisi->onay?0:1; // Gelen veri eğer TRUE (1) ise TERNARY yapısından dolayı 0 olucak FALSE (0) ise yine 1 olacaktır.

                    $Islem->setAnketProjectUpdOnay($gelenID, $gelenTersOnay);
                }
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/anketler");
                exit();
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function anketAdd()
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            if (isset($_POST["queryName"])) {
                $queryName = $_POST["queryName"];
            } else {
                $queryName = "";
            }
            if (isset($_POST["queryString"])) {
                $gelenQuery = $_POST["queryString"];
            } else {
                $gelenQuery = "";
            }
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            if ($queryName != "" and $gelenQuery != "") {
                $gelenBaslik        = $queryName[0]; // [0] parametre göndermede baslik olarak gönderilmişti.
                $gelenBaslikmetni   = $queryName[1]; // [1] parametre göndermede baslik metni olarak gönderilmişti.
                $gelenAciklamaMetni = $queryName[2]; // [2] parametre göndermede açıklama metni olarak gönderilmişti.
                $gelenAnketGiris    = $queryName[3]; // [3] parametre göndermede ankete giriş bilgisi olarak gönderilmişti.
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 
                $onay               = 0; // Normal olarak 0 lakin üst düzey ise aşağıda düzelticez.

                $yoneticiBilgisi = $Islem->getControlMember($_SESSION["Yonetici"]); // Kullanıcının bilgilerini aldım eğer üst düzey yöneticiyse otomatik olarak onaylansın.
                if ($yoneticiBilgisi->yonetimFaktoru) {
                    $onay           = 1;
                }
                $Islem->setAnketProject($yoneticiBilgisi->id, $gelenBaslik, $gelenBaslikmetni, $gelenAciklamaMetni, $gelenAnketGiris, $gelenSerialize, $onay); // Sistemden ekleme işlemi isteği yolladık. (Yonetici verilerinin kayıtlı olması için id ekledik.)

                echo "Onaylandı."; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function anketUpdate()
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            if (isset($_POST["queryName"])) {
                $queryName = $_POST["queryName"];
            } else {
                $queryName = "";
            }
            if (isset($_POST["queryString"])) {
                $gelenQuery = $_POST["queryString"];
            } else {
                $gelenQuery = "";
            }
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            if ($queryName != "" and $gelenQuery != "") {
                $gelenBaslik        = $queryName[0]; // [0] parametre göndermede baslik olarak gönderilmişti.
                $gelenBaslikMetni   = $queryName[1]; // [1] parametre göndermede baslik metni olarak gönderilmişti.
                $gelenAciklamaMetni = $queryName[2]; // [2] parametre göndermede açıklama metni olarak gönderilmişti.
                $gelenAnketGiris    = $queryName[3]; // [3] parametre göndermede ankete giriş bilgisi olarak gönderilmişti.
                $gelenID            = $queryName[4]; // [3] parametre göndermede anketin ID değeri olarak gönderilmişti.
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 

                $Islem->setAnketProjectUpd($gelenID, $gelenBaslik, $gelenBaslikMetni, $gelenAciklamaMetni,$gelenAnketGiris, $gelenSerialize); // Sistemden ekleme işlemi isteği yolladık. (Yonetici verilerinin kayıtlı olması için id ekledik.)

                echo "Onaylandı."; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }

    public function adminAnket()
    {
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            $data = array(
                "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                "yonetimBilgi" => $yonetimBilgi,
                "anketKayitlarim" => $Islem->getMyAnketProjects($yonetimBilgi->id)
            );

            return view('adminAnket', $data);
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function adminAnketSil($gelenVeri = "")
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);

                // Kişi kendi üyeliğinin dışında bir anketi silmeye çalışırsa onu engelleyelim
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);

                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID)) { 
                    $Islem->setAnketProjectDel($gelenVeri); // ID değerine göre anketi sildik.
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/leave");
                    exit();
                }
            }
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/adminAnket");
            exit();
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function ustAdminAnketSil($gelenVeri = "")
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($yonetimBilgi->yonetimFaktoru) { // Eğer yönetici istiyorsa silme hakkı verdik.
                if ($gelenVeri != "") {
                    $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                    $Islem->setAnketProjectDel($gelenVeri); // ID değerine göre anketi sildik.
                }
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/anketler");
                exit();
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/adminAnket");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function adminAnketGuncelle($gelenVeri = "")
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);

                // Kişi kendi üyeliğinin dışında bir anketi güncellemeye çalışırsa onu engelleyelim
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);

                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) { // Eğer yönetici istiyorsa güncelleme hakkı verdik.
                    $data = array(
                        "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                        "yonetimBilgi" => $yonetimBilgi,
                        "anketBilgisi" => $anketBilgisi
                    );
                    return view('adminAnketGuncelle', $data);
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/leave");
                    exit();
                }
            }
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/adminAnket");
            exit();
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function adminAnketLinkOlustur($gelenVeri = ""){ // SEO yapısıyla linkler oluşturalım.
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if($anketBilgisi->onay or $yonetimBilgi->yonetimFaktoru){ // Onaylı değilse anket linki oluşturulmasın. (Yonetici oluşturma hakkı verdik.)
                    if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) { // Eğer yönetici istiyorsa silme hakkı verdik.
                        $seoLink = SEO($anketBilgisi->baslik, $anketBilgisi->id);

                        header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/publicAnketler/Anketler/" . $seoLink);
                        exit();
                    } else {
                        // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                        header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/leave");
                        exit();
                    }
                }else{
                    // Eğer kişi onaysız açmaya çalışıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/leave");
                    exit();
                }
            }
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/adminAnket");
            exit();
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function anketAnaliz($gelenVeri = ""){
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) { // Eğer yönetici istiyorsa silme hakkı verdik.
                    $gelenVeri = $Islem->getAnketResult($anketBilgisi->id);
                    $data = array(
                        "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                        "yonetimBilgi" => $yonetimBilgi,
                        "anketBilgisi" => $anketBilgisi,
                        "publicVeri"   => $gelenVeri
                    );
                    
                    return view('adminAnketAnaliz', $data);
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/leave");
                    exit();
                }
            }
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController/adminAnket");
            exit();
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    // Çıkış yapma yapısı
    public function leave()
    {
        $Ayar  = new AyarModel();
        unset($_SESSION["Yonetici"]);
        session_destroy();

        header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
        exit();
    }
}
