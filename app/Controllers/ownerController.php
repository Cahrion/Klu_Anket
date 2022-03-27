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
    public function anketAdd()
    {
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            if ($_POST["queryName"]) {
                $queryName = $_POST["queryName"];
            } else {
                $queryName = "";
            }
            if ($_POST["queryString"]) {
                $gelenQuery = $_POST["queryString"];
            } else {
                $gelenQuery = "";
            }
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            if ($queryName != "" and $gelenQuery != "") {
                $gelenBaslik        = $queryName[0]; // [0] parametre göndermede baslik olarak gönderilmişti.
                $gelenBaslikmetni   = $queryName[1]; // [1] parametre göndermede baslik metni olarak gönderilmişti.
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 
                $onay               = 0; // Normal olarak 0 lakin üst düzey ise aşağıda düzelticez.

                $yoneticiBilgisi = $Islem->getControlMember($_SESSION["Yonetici"]); // Kullanıcının bilgilerini aldım eğer üst düzey yöneticiyse otomatik olarak onaylansın.
                if ($yoneticiBilgisi->yonetimFaktoru) {
                    $onay           = 1;
                }
                $Islem->setAnketProject($yoneticiBilgisi->id, $gelenBaslik, $gelenBaslikmetni, $gelenSerialize, $onay); // Sistemden ekleme işlemi isteği yolladık. (Yonetici verilerinin kayıtlı olması için id ekledik.)

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

                if ($yonetimBilgi->id == $anketBilgisi->yoneticiID) {
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
