<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\IslemModel;

\Config\Services::session();

class OwnerController extends Controller
{
    // Ana yapıda sitenin merkez kısmına erişimi koydum kişi buradan öncelikle anket ekleme bölümüne giriş yapar.
    public function index()
    {
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $data = array(
                "yonetimBilgi" => $Islem->getControlMember($_SESSION["Yonetici"])
            );
            return view('Central', $data);
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketler()
    {
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                $data = array(
                    "yonetimBilgi"  => $yonetimBilgi,
                    "anketKayitlari" => $Islem->getAnketProjects()
                );
                $_SESSION["link"] = $_SERVER["PHP_SELF"];
                return view('adminAnketler', $data);
            } else {
                header("Location: " . base_url("OwnerController"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketOnay($gelenID = "")
    { // Anketi onaylıyoruz veya onay kaldırıyoruz.

        helper("fonksiyonlar"); // Guvenlik filtresi fonksiyonunu kullanmak amaçlı
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) { // Yonetimini sorguladık.
                if ($gelenID != "") {
                    $gelenID    = GuvenlikFiltresi($gelenID);
                    $gelenAnketVerisi = $Islem->getAnketProject($gelenID); // Anketi aldık.

                    $gelenTersOnay  = $gelenAnketVerisi->onay ? 0 : 1; // Gelen veri eğer TRUE (1) ise TERNARY yapısından dolayı 0 olucak FALSE (0) ise yine 1 olacaktır.

                    $Islem->setAnketProjectUpdOnay($gelenID, $gelenTersOnay);
                }
                if (isset($_SESSION["link"])) {
                    header("Location: " . $_SESSION["link"]);
                    exit();
                } else {
                    header("Location: " . base_url("OwnerController/anketler"));
                    exit();
                }
            } else {
                header("Location: " . base_url("OwnerController"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketAdd()
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            if (isset($_POST["queryName"])) {
                $queryName = [];
                foreach ($_POST["queryName"] as $queryNameKey => $queryNameVeri) {
                    $queryName[$queryNameKey] = GuvenlikFiltresi($queryNameVeri);
                }
            } else {
                $queryName = "";
            }
            if (isset($_POST["queryString"])) {
                $gelenQuery = [];
                foreach ($_POST["queryString"] as $keyGroup => $queryStringGroup) { // Groupları aldık.
                    foreach ($queryStringGroup as $keyGroupIn => $queryStringGroupIn) { // Group içindeki bilgileri aldık.
                        foreach ($queryStringGroupIn as $keyGroupDetay => $queryStringDetay) { // Group içinin detaylarını aldık.
                            $queryStringBilgi = is_array($queryStringDetay); // Group içinde eğer array yapısı varsa ki (Sorular array yapısında geliyor.)
                            if ($queryStringBilgi) { // Array yapısında gelenleri bir daha for döngüsüne aldık.
                                foreach ($queryStringDetay as $keyGroupSoruDetay => $queryStringSoruDetay) {
                                    $gelenQuery[$keyGroup][$keyGroupIn][$keyGroupDetay][$keyGroupSoruDetay] = GuvenlikFiltresi($queryStringSoruDetay); // Guvenlik filtresi uygulayıp yeniden gönderdik.
                                }
                            } else {
                                $gelenQuery[$keyGroup][$keyGroupIn][$keyGroupDetay] = GuvenlikFiltresi($queryStringDetay); // Guvenlik filtresi uygulayıp yeniden gönderdik.
                            }
                        }
                    }
                }
            } else {
                $gelenQuery = "";
            }
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            if ($queryName != "" and $gelenQuery != "") {
                $gelenBaslik        = $queryName[0]; // [0] parametre göndermede baslik olarak gönderilmişti.
                $gelenBaslikmetni   = $queryName[1]; // [1] parametre göndermede baslik metni olarak gönderilmişti.
                $gelenAciklamaMetni = $queryName[2]; // [2] parametre göndermede açıklama metni olarak gönderilmişti.
                $gelenAnketKitle    = $queryName[3]; // [3] parametre göndermede anket kitle bilgisi olarak gönderilmişti.
                $gelenAnketGiris    = $queryName[4]; // [4] parametre göndermede ankete giriş bilgisi olarak gönderilmişti.
                $gelenAnketGorus    = $queryName[5]; // [5] parametre göndermede ankete gorus bilgisi olarak gönderilmişti.
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 
                $onay               = 0; // Normal olarak 0 lakin üst düzey ise aşağıda düzelticez.

                $yoneticiBilgisi = $Islem->getControlMember($_SESSION["Yonetici"]); // Kullanıcının bilgilerini aldım eğer üst düzey yöneticiyse otomatik olarak onaylansın.
                if ($yoneticiBilgisi->yonetimFaktoru) {
                    $onay           = 1;
                }
                $Islem->setAnketProject($yoneticiBilgisi->id, $gelenBaslik, $gelenBaslikmetni, $gelenAciklamaMetni, $gelenAnketKitle, $gelenAnketGiris, $gelenAnketGorus, $gelenSerialize, $onay); // Sistemden ekleme işlemi isteği yolladık. (Yonetici verilerinin kayıtlı olması için id ekledik.)

                echo "Onaylandı."; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
            } else {
                header("Location: " . base_url("OwnerController"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketUpdate($gelenAnket = "")
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            if ($gelenAnket != "") {
                $degisimFlag = 0;
                $gelenAnket = GuvenlikFiltresi($gelenAnket);
                $gelenAnketVeri = $Islem->getAnketProject($gelenAnket);
                $gelenAnketUnserialize = unserialize($gelenAnketVeri->serialize);

                $queryName = [];
                if (isset($_POST["queryName"])) {
                    foreach ($_POST["queryName"] as $queryNameKey => $queryNameVeri) {
                        $queryName[$queryNameKey] = GuvenlikFiltresi($queryNameVeri);
                    }
                } else {
                    $queryName = "";
                }
                if (isset($_POST["queryString"])) {
                    $gelenQuery = [];
                    foreach ($_POST["queryString"] as $keyGroup => $queryStringGroup) { // Groupları aldık.
                        foreach ($queryStringGroup as $keyGroupIn => $queryStringGroupIn) { // Group içindeki bilgileri aldık.
                            if ($keyGroupIn == 2) {
                                if (count($queryStringGroupIn) != count($gelenAnketUnserialize[$keyGroup][2])) {
                                    $degisimFlag = 1;
                                }
                            }
                            if (!$degisimFlag) {
                                if ($keyGroupIn == 1) {
                                    if (count($queryStringGroupIn) != count($gelenAnketUnserialize[$keyGroup][1])) {
                                        $degisimFlag = 1;
                                    }
                                }
                            }

                            foreach ($queryStringGroupIn as $keyGroupDetay => $queryStringDetay) { // Group içinin detaylarını aldık.

                                $queryStringBilgi = is_array($queryStringDetay); // Group içinde eğer array yapısı varsa ki (Sorular array yapısında geliyor.)

                                if ($queryStringBilgi) { // Array yapısında gelenleri bir daha for döngüsüne aldık.
                                    foreach ($queryStringDetay as $keyGroupSoruDetay => $queryStringSoruDetay) {
                                        $gelenQuery[$keyGroup][$keyGroupIn][$keyGroupDetay][$keyGroupSoruDetay] = GuvenlikFiltresi($queryStringSoruDetay); // Guvenlik filtresi uygulayıp yeniden gönderdik.

                                        // Eğer kullanıcı yeni bir soru eklediyse sistemdeki önceki veriler silinsin.
                                        if (!$degisimFlag) {
                                            if ($keyGroupSoruDetay == 0) {
                                                if (!($queryStringSoruDetay == $gelenAnketUnserialize[$keyGroup][$keyGroupIn][$keyGroupDetay][0])) {
                                                    $degisimFlag = 1;
                                                }
                                            }
                                        }
                                    }
                                } else {
                                    $gelenQuery[$keyGroup][$keyGroupIn][$keyGroupDetay] = GuvenlikFiltresi($queryStringDetay); // Guvenlik filtresi uygulayıp yeniden gönderdik.

                                    // Eğer kullanıcı yeni bir seçenek eklediyse sistemdeki önceki veriler silinsin.
                                    if (!$degisimFlag) {
                                        if ($keyGroupIn == 1) {
                                            if (!($queryStringDetay == $gelenAnketUnserialize[$keyGroup][$keyGroupIn][$keyGroupDetay])) {
                                                $degisimFlag = true;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $gelenQuery = "";
                }
            }
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            if ($queryName != "" and $gelenQuery != "" and $gelenAnket != "") {
                $gelenBaslik        = $queryName[0]; // [0] parametre göndermede baslik olarak gönderilmişti.
                $gelenBaslikMetni   = $queryName[1]; // [1] parametre göndermede baslik metni olarak gönderilmişti.
                $gelenAciklamaMetni = $queryName[2]; // [2] parametre göndermede açıklama metni olarak gönderilmişti.
                $gelenAnketKitle    = $queryName[3]; // [3] parametre göndermede anket kitle bilgisi olarak gönderilmişti.
                $gelenAnketGiris    = $queryName[4]; // [4] parametre göndermede ankete giriş bilgisi olarak gönderilmişti.
                $gelenAnketGorus    = $queryName[5]; // [5] parametre göndermede ankete gorus bilgisi olarak gönderilmişti.
                $gelenID            = $queryName[6]; // [6] parametre göndermede anketin ID değeri olarak gönderilmişti.
                $gelenSerialize     = serialize($gelenQuery); // Gelen array yapısını serialize ederek database de tutabiliriz. 

                if ($degisimFlag) {
                    $Islem->setAnketResultsDel($gelenAnketVeri->id);
                }
                $Islem->setAnketProjectUpd($gelenID, $gelenBaslik, $gelenBaslikMetni, $gelenAciklamaMetni, $gelenAnketKitle, $gelenAnketGiris, $gelenAnketGorus, $gelenSerialize); // Sistemden ekleme işlemi isteği yolladık. (Yonetici verilerinin kayıtlı olması için id ekledik.)

                echo "Onaylandı."; // AJAX yapısı olduğundan dolayı geriye veri göndermek için kullanalım.
            } else {
                header("Location: " . base_url("OwnerController"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }

    public function adminAnket()
    {
        if (isset($_SESSION["Yonetici"])) {
            // Kullanıcı bilgilerini kullanmak amacıyla IslemModel() yapısından veri alıyor ve ön yüze gönderiyoruz.
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            $data = array(
                "yonetimBilgi" => $yonetimBilgi,
                "anketKayitlarim" => $Islem->getMyAnketProjects($yonetimBilgi->id)
            );

            return view('adminAnket', $data);
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function adminAnketSil($gelenVeri = "")
    {
        helper("fonksiyonlar");
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
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            }
            header("Location: " . base_url("OwnerController/adminAnket"));
            exit();
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function ustAdminAnketSil($gelenVeri = "")
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($yonetimBilgi->yonetimFaktoru) { // Eğer yönetici istiyorsa silme hakkı verdik.
                if ($gelenVeri != "") {
                    $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                    $Islem->setAnketProjectDel($gelenVeri); // ID değerine göre anketi sildik.
                }
                header("Location: " . base_url("OwnerController/anketler"));
                exit();
            } else {
                header("Location: " . base_url("OwnerController/adminAnket"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function adminAnketGuncelle($gelenVeri = "")
    {
        helper("fonksiyonlar");
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
                        "yonetimBilgi" => $yonetimBilgi,
                        "anketBilgisi" => $anketBilgisi
                    );
                    return view('adminAnketGuncelle', $data);
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            }
            header("Location: " . base_url("OwnerController/adminAnket"));
            exit();
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function adminAnketLinkOlustur($gelenVeri = "")
    { // SEO yapısıyla linkler oluşturalım.
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if ($anketBilgisi->onay or $yonetimBilgi->yonetimFaktoru) { // Onaylı değilse anket linki oluşturulmasın. (Yonetici oluşturma hakkı verdik.)
                    if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) {
                        $seoLink = SEO($anketBilgisi->baslik, $anketBilgisi->id);

                        header("Location: " . base_url("publicAnketler/Anketler/" . $seoLink));
                        exit();
                    } else {
                        // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                        header("Location: " . base_url("OwnerController/leave"));
                        exit();
                    }
                } else {
                    // Eğer kişi onaysız açmaya çalışıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            }
            header("Location: " . base_url("OwnerController/adminAnket"));
            exit();
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketAnaliz($gelenVeri = "")
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) {
                    $gelenVeri = $Islem->getAnketResult($anketBilgisi->id);
                    $data = array(
                        "yonetimBilgi" => $yonetimBilgi,
                        "anketBilgisi" => $anketBilgisi,
                        "publicVeri"   => $gelenVeri
                    );

                    return view('adminAnketAnaliz', $data);
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            } else {
                header("Location: " . base_url("OwnerController/adminAnket"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketAnalizExcel($gelenVeri = "")
    {

        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {

            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($gelenVeri != "") {

                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) {
                    $publicVeri = $Islem->getAnketResult($anketBilgisi->id);


                    $SoruGrouplari     = []; // Grouplar şeklinde datalarımızı tutalım
                    $SoruVerileri     = []; // Gelen soru şıklarını alalım
                    $SoruMetinleri     = []; // Gelen soru metinlerini alalım
                    $anketUnSerialize = unserialize($anketBilgisi->serialize);
                    foreach ($anketUnSerialize as $keyGroup => $anketGroup) { // Groupları aldık
                        foreach ($anketGroup[2] as $keySoru => $anketSorular) { // Group içinde soruları aldık.
                            $SoruMetinleri[$keySoru + 1] = $anketSorular;
                            foreach ($anketGroup[1] as $gelenSoruSecenekler) { // Group içine seçenekleri yazdırdık ve puanları 0 yaptık (İşaretlenmemiş anlamında.)
                                $gelenSoruSecenekler = GuvenlikFiltresi($gelenSoruSecenekler);
                                $SoruVerileri[$keySoru + 1][$gelenSoruSecenekler] = 0;
                            }
                        }
                        $SoruGrouplari[$keyGroup] = [$SoruMetinleri, $SoruVerileri]; // Elimizdeki verileri düzenli bir şekilde ana grup yapısına ekledik.
                        $SoruVerileri             = [];
                        $SoruMetinleri            = []; // Sistemde yeni veriler üst üste gelmesin diye eski verileri siliyoruz.
                    }

                    foreach ($publicVeri as $publicRowVeri) { // getResult() yapısıyla geldiği için öncelikle bir foreach döngüsüne girelim.
                        $gelenUnSerializeVeri = unserialize($publicRowVeri->serialize);
                        foreach ($gelenUnSerializeVeri as $keyGroup => $gelenGroupVeri) { // İlk döngüde Grouplar geldiği için grupları alalım.
                            foreach ($gelenGroupVeri as $keySoru => $gelenSoruVeri) { // Soruları alalım.
                                $ayracSoru = explode("-", $gelenSoruVeri); // Sorular (SoruNumarası-SoruCevabı) olarak geldiği için explode() ile bölelim
                                $SoruGrouplari[$keyGroup][1][$ayracSoru[0]][$ayracSoru[1]] += 1; // Burada soru numarası ve soru cevabına eşit gelen değere ekleme yaptık.
                            }
                        }
                    }

                    $gelenSutunArray = []; // Gelen verileri sutunlar diye ayırdık.
                    $gelenSatirArray = []; // Gelen verileri satırlar diye ayırdık.
                    foreach ($anketUnSerialize as $keyGroup => $anketGroup) {
                        $SutunArray = [];
                        $SutunArray[] = $anketGroup[0][1]; // Grup başlık verisi
                        foreach ($anketGroup[1] as $gelenSoruSecenekler) { // Seçenekler oluyor.
                            $SutunArray[] = $gelenSoruSecenekler;
                        }
                        $gelenSutunArray[$keyGroup] = $SutunArray;
                        $SatirArray = [];
                        foreach ($SoruGrouplari[$keyGroup][0] as $keySoru => $soru) {
                            $SatirSoruArray = [];
                            $SatirSoruArray[] = $soru[0];
                            foreach ($SoruGrouplari[$keyGroup][1][$keySoru] as $secenekler) {
                                $SatirSoruArray[] = $secenekler;
                            }
                            $SatirArray[$keySoru] = $SatirSoruArray;
                        }
                        $gelenSatirArray[$keyGroup] = $SatirArray;
                    }
                    $fileName = "klu_anket_" . $anketBilgisi->id . "_" . date('Y-m-d') . ".xls";

                    // Headers for download 
                    header("Content-Type: application/vnd.ms-excel");
                    header("Content-Disposition: attachment; filename=\"$fileName\"");

                    // Render excel data 
                    foreach ($gelenSutunArray as $keyArr => $gelenSutunArr) {
                        // Column names  
                        echo "<table style='border:1px solid black;border-collapse: collapse;'>";
                        echo "<tr>";
                        foreach ($gelenSutunArr as $gelenSutunName) {
                            $gelenSutunName = mb_convert_encoding($gelenSutunName, "windows-1254", "utf-8"); // Türkçe karakter oluştur.
                            echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>";
                            echo $gelenSutunName;
                            echo "</th>";
                        }
                        echo "</tr>";
                        foreach ($gelenSatirArray[$keyArr] as $gelenSatirAlan) {
                            echo "<tr>";
                            foreach ($gelenSatirAlan as $gelenMetin) {
                                echo "<td style='border: 1px solid black;border-collapse: collapse;'>";
                                $gelenMetin = mb_convert_encoding($gelenMetin, "windows-1254", "utf-8"); // Türkçe karakter oluştur.
                                echo $gelenMetin;
                                echo "</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "<br>";
                    }
                    exit;
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            } else {
                header("Location: " . base_url("OwnerController/adminAnket"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketAnalizExcelPlus($gelenVeri = "")
    {

        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {

            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($gelenVeri != "") {

                $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                if (($yonetimBilgi->id == $anketBilgisi->yoneticiID) or $yonetimBilgi->yonetimFaktoru) {
                    $publicVeri = $Islem->getAnketResult($anketBilgisi->id);
                    $Islem  = new IslemModel();
                    $anketBilgisi = $Islem->getAnketProject($gelenVeri);
                    $publicVeri = $Islem->getAnketResultExcel($anketBilgisi->id);


                    $SoruGrouplari      = []; // Grouplar şeklinde datalarımızı tutalım
                    $SoruVerileri       = []; // Gelen soru şıklarını alalım
                    $SoruMetinleri      = []; // Gelen soru metinlerini alalım
                    $anketUnSerialize = unserialize($anketBilgisi->serialize);
                    foreach ($anketUnSerialize as $keyGroup => $anketGroup) { // Groupları aldık
                        foreach ($anketGroup[2] as $keySoru => $anketSorular) { // Group içinde soruları aldık.
                            $SoruMetinleri[$keySoru + 1] = $anketSorular[0];
                            $SoruVerileri[$keySoru + 1] = "Boş";
                        }
                        $SoruGrouplari[$keyGroup] = [$SoruMetinleri, $SoruVerileri]; // Elimizdeki verileri düzenli bir şekilde ana grup yapısına ekledik.
                        $SoruVerileri             = [];
                        $SoruMetinleri            = []; // Sistemde yeni veriler üst üste gelmesin diye eski verileri siliyoruz.
                    }

                    $fileName = "klu_anket_plus_" . $anketBilgisi->id . "_" . date('Y-m-d') . ".xls";
                    // Headers for download 
                    // header("Content-Type: application/vnd.ms-excel");
                    // header("Content-Disposition: attachment; filename=\"$fileName\"");

                    foreach ($publicVeri as $publicRowVeri) { // getResult() yapısıyla geldiği için öncelikle bir foreach döngüsüne girelim.
                        $gelenUnSerializeVeri = unserialize($publicRowVeri->serialize);
                        $KullaniciIP      = $publicRowVeri->kullaniciIP;
                        $bransTur         = $publicRowVeri->bransTur;
                        $fakulteID        = $publicRowVeri->fakulteID;
                        $birimID          = $publicRowVeri->birimID;
                        $gonderimTarihi   = $publicRowVeri->gonderimTarihi;
                        $anketGorus       = $publicRowVeri->anketGorus;
                        echo "<table style='border:1px solid black;border-collapse: collapse;'>";
                        echo "<tr>";
                        echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>IP adresi</th>";
                        foreach ($SoruGrouplari as $keyGroup => $gelenGroupVeri) { // İlk döngüde Grouplar geldiği için grupları alalım.
                            foreach ($SoruGrouplari[$keyGroup][0] as $gelenSutunName) {
                                $gelenSutunNameTR = mb_convert_encoding($gelenSutunName, "windows-1254", "utf-8");
                                echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>";
                                echo $gelenSutunNameTR;
                                echo "</th>";
                            }
                        }
                        echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>Brans</th>";
                        echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>Fakulte ID</th>";
                        echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>Birim ID</th>";
                        echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>Gonderim Tarihi</th>";
                        if ($anketBilgisi->anketGorus) {
                            echo "<th style='border: 1px solid black;border-collapse: collapse;background-color:#D7D1CB'>Anket Gorusu</th>";
                        }
                        echo "</tr>";
                        echo "<tr style='height:50px'>";
                        echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $KullaniciIP . "</td>";
                        foreach ($SoruGrouplari as $keyGroup => $gelenGroupVeri) { // İlk döngüde Grouplar geldiği için grupları alalım.
                            if(isset($gelenUnSerializeVeri[$keyGroup])){
                                foreach ($gelenUnSerializeVeri[$keyGroup] as $keySoru => $gelenSoruVeri) { // Soruları alalım.
                                    $ayracSoru = explode("-", $gelenSoruVeri); // Sorular (SoruNumarası-SoruCevabı) olarak geldiği için explode() ile bölelim
                                    $SoruGrouplari[$keyGroup][1][$ayracSoru[0]] = $ayracSoru[1]; // Burada soru numarası ve soru cevabına eşit gelen değere ekleme yaptık.
                                }
                            }
                            foreach ($SoruGrouplari[$keyGroup][1] as $gelenSatirAlan) {
                                $gelenMetinTR = mb_convert_encoding($gelenSatirAlan, "windows-1254", "utf-8");
                                echo "<td style='border: 1px solid black;border-collapse: collapse;'>";
                                echo $gelenMetinTR;
                                echo "</td>";
                            }
                        }
                        echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $bransTur . "</td>";
                        echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $fakulteID . "</td>";
                        echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $birimID . "</td>";
                        echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $gonderimTarihi . "</td>";
                        if ($anketBilgisi->anketGorus) {
                            $anketGorusVeri = mb_convert_encoding($anketGorus, "windows-1254", "utf-8");
                            echo "<td style='border: 1px solid black;border-collapse: collapse;'>" . $anketGorusVeri . "</td>";
                        }
                        echo "</tr>";
                        echo "</table>";
                    }
                    exit;
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            } else {
                header("Location: " . base_url("OwnerController/adminAnket"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    // Admin Profil
    public function adminProfil($gelenVeri = "")
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            // Gelen veriyi güvenlik taramasından geçiriyoruz eğer gelmediyse geri gönderelim.
            if ($gelenVeri != "") {
                $gelenVeri          = GuvenlikFiltresi($gelenVeri);
                if ($yonetimBilgi->yonetimFaktoru) {
                    $gelenYonetici = $Islem->getControlMemberID($gelenVeri);
                    $data = array(
                        "yonetimBilgi" => $yonetimBilgi,
                        "gelenYonetici" => $gelenYonetici,
                        "anketKayitlarim" => $Islem->getMyAnketProjects($gelenYonetici->id)
                    );
                    $_SESSION["link"] = $_SERVER["PHP_SELF"];
                    return view('adminProfil', $data);
                } else {
                    // Eğer kişi farklı bir ID değerine saldırıyorsa veya bug deniyorsa onun şuanki kaydını otomatikmen çıkartalım.
                    header("Location: " . base_url("OwnerController/leave"));
                    exit();
                }
            } else {
                header("Location: " . base_url("OwnerController/adminAnket"));
                exit();
            }
        } else {
            header("Location: " . base_url());
            exit();
        }
    }
    public function anketorList()
    {
        helper("fonksiyonlar");
        if (isset($_SESSION["Yonetici"])) {
            $Islem  = new IslemModel();
            $yonetimBilgi = $Islem->getControlMember($_SESSION["Yonetici"]);
            if ($yonetimBilgi->yonetimFaktoru) {
                if (isset($_POST["queryString"])) {
                    $gelenYoneticiLike = GuvenlikFiltresi($_POST["queryString"]);
                    $yoneticiler = $Islem->getControlMembersLike($gelenYoneticiLike);
                    foreach ($yoneticiler as $yoneticilerV) {
                        echo '<div style="border: 1px solid grey;padding:15px;border-radius:5px;margin-bottom:4px;cursor:pointer" onClick="systemPost(\'' . $yoneticilerV->id . '\');">' . $yoneticilerV->emailAdresi . '</div>';
                    }
                }
            }
        }
    }
    // Çıkış yapma yapısı
    public function leave()
    {
        unset($_SESSION["Yonetici"]);
        session_destroy();

        header("Location: " . base_url());
        exit();
    }
}
