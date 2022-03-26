<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\AyarModel;
use App\Models\IslemModel;

\Config\Services::session();

class adminController extends Controller
{

    // ----------------------------------------------
    // -- Veri Alma
    // ----------------------------------------------

    // Admin yöneticileri burada görür.
    public function index()
    {
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                $data = array(
                    "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                    "yonetimBilgi" => $yonetimBilgi,
                    "YoneticilerKayitlari" => $Islem->getControlMembers()
                );

                return view('adminPanel', $data);
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }

    // Admin yöneticileri burada ekler.
    public function adminEkle()
    {
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                $data = array(
                    "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                    "yonetimBilgi" => $yonetimBilgi
                );
                return view('adminPanelEkle', $data);
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }

    // Admin yönetici bilgilerini buradan günceller.
    public function adminGuncelle($gelenVeri = "") // $gelenVeri = Kullanıcının ID değeri
    {
        helper("fonksiyonlar");
        // Site Ayarlarını kullanmak amacıyla AyarModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                if ($gelenVeri != "") {
                    $gelenVeri = GuvenlikFiltresi($gelenVeri);

                    $data = array(
                        "SiteLinki" => $Ayar->get_Ayars("SiteLinki"),
                        "yonetimBilgi" => $yonetimBilgi,
                        "yoneticiBilgileri" => $Islem->getControlMemberID($gelenVeri) // gelenVeri = id verisiyle kullanıcının bilgileri çektik.
                    );

                    return view('adminPanelGuncelle', $data);
                } else {
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController");
                    exit();
                }
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    // ----------------------------------------------
    // -- Sonuç
    // ----------------------------------------------

    public function adminPanelEkle()
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                if (isset($_POST["emailAdresi"])) {
                    $gelenEmail = GuvenlikFiltresi($_POST["emailAdresi"]);
                } else {
                    $gelenEmail = "";
                }
                if (isset($_POST["yonetimFaktoru"])) {
                    $gelenFaktor = GuvenlikFiltresi($_POST["yonetimFaktoru"]);
                } else {
                    $gelenFaktor = "";
                }
                if ($gelenEmail != "" and $gelenFaktor != "") {
                    $Islem->setControlMemberNew($gelenEmail, $gelenFaktor); // ilk kısma Email adresi ve ikinci kısma Faktörü (Rolü)
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController");
                    exit();
                } else {
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController/adminEkle");
                    exit();
                }
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function adminPanelGuncelle($gelenVeri = "")
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
                if ($gelenVeri != "") {
                    $gelenVeri = GuvenlikFiltresi($gelenVeri);
                    // Verileri güvenlik faktörüne bağlı kalarak alım yapıyoruz
                    if (isset($_POST["emailAdresi"])) {
                        $gelenEmail = GuvenlikFiltresi($_POST["emailAdresi"]);
                    } else {
                        $gelenEmail = "";
                    }
                    if (isset($_POST["yonetimFaktoru"])) {
                        $gelenFaktor = GuvenlikFiltresi($_POST["yonetimFaktoru"]);
                    } else {
                        $gelenFaktor = "";
                    }
                    if ($gelenEmail != "" and $gelenFaktor != "") {
                        if($gelenVeri == $yonetimBilgi->id){ // Kendi e-posamızın değiştirilmesini istiyorsak SESSION verisini de değiştirelim
                            $_SESSION["Yonetici"] = $gelenEmail;
                        }

                        $Islem->setControlMemberUpd($gelenVeri, $gelenEmail, $gelenFaktor); // Birinci kısma ID değerini, ikinci kısma Email adresi ve üçüncü kısma Faktörü (Rolü)
                        header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController");
                        exit();
                    } else {
                        header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController/adminGuncelle");
                        exit();
                    }
                } else {
                    header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController");
                    exit();
                }
            } else {
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/ownerController");
                exit();
            }
        } else {
            header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public");
            exit();
        }
    }
    public function adminPanelSil($gelenVeri = "") // ID değeri geliyor.
    {
        helper("fonksiyonlar");
        $Ayar  = new AyarModel();
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
                if ($gelenVeri != "") {
                    // Kişi kendi üyeliğini silmeye çalışırsa otomatik olarak engelleyelim
                    if ($yonetimBilgi->id != $gelenVeri) {
                        $Islem->setControlMemberDel($gelenVeri); // ID değerine göre kişinin uyeliğini sildik.
                    }
                }
                header("Location: " . $Ayar->get_Ayars("SiteLinki") . "public/adminController");
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
}
