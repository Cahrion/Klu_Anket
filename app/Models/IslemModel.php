<?php
namespace App\Models;
use CodeIgniter\Model;

class IslemModel extends Model {
    // --------------------------------
    // -- Üye çekme ve benzer işler için
    // --------------------------------
    public function getControlMember($degree){
        $db = \Config\Database::connect();
        $data = array(
            "emailAdresi" => $degree
        );
        $result = $db->table("uyeler")->getWhere($data)->getRow();
        return $result;
    }
    public function getControlMemberID($degree){
        $db = \Config\Database::connect();
        $data = array(
            "id" => $degree
        );
        $result = $db->table("uyeler")->getWhere($data)->getRow();
        return $result;
    }
    public function getControlMembers(){
        $db = \Config\Database::connect();
        $result = $db->table("uyeler")->get()->getResult();
        return $result;
    }
    public function setControlMemberNew($email, $Faktor){
        // Email adresi ve Yönetim Rolu girilerek ekleme işlemi yapılabilir.
        $db = \Config\Database::connect();
        $data = array(
            "emailAdresi" => $email,
            "yonetimFaktoru" => $Faktor,
        );
        $result = $db->table("uyeler")->insert($data);
        return $result;
    }
    public function setControlMemberDel($id){
        // ID verisi girilerek silme işlemi yapılabilir.
        $db = \Config\Database::connect();
        $data = array(
            "id" => $id
        );
        $result = $db->table("uyeler")->delete($data);
        return $result;
    }
    public function setControlMemberUpd($id, $email, $Faktor){
        // ID verisi girilerek güncelleme işlemi yapılabilir. (Email ve Faktor)
        $db = \Config\Database::connect();
        $data = array(
            "id" => $id
        );
        $newData = array(
            "emailAdresi" => $email,
            "yonetimFaktoru" => $Faktor
        );
        $result = $db->table("uyeler")->where($data)->update($newData);
        return $result;
    }
    
    // --------------------------------
    // -- Anket için
    // --------------------------------
    
    public function setAnketProject($gelenYonetici, $baslik, $metin, $aciklama,$gelenAnketKitle,$gelenAnketGiris,$gelenAnketGorus, $serialize, $onay){
        // ID verisi girilerek güncelleme işlemi yapılabilir. (Email ve Faktor)
        $db = \Config\Database::connect();
        $data = array(
            "yoneticiID" => $gelenYonetici,
            "baslik" => $baslik,
            "metin" => $metin,
            "aciklama" => $aciklama,
            "anketKitle" => $gelenAnketKitle,
            "anketGiris" => $gelenAnketGiris,
            "anketGorus" => $gelenAnketGorus,
            "serialize" => $serialize,
            "onay" => $onay
        );
        $result = $db->table("anketler")->insert($data);
        return $result;
    }

    public function setAnketProjectUpd($gelenAnketID, $baslik, $metin, $aciklama, $gelenAnketKitle, $gelenAnketGiris, $gelenAnketGorus, $serialize){
        // ID verisi girilerek güncelleme işlemi yapılabilir. (Email ve Faktor)
        $db = \Config\Database::connect();
        $data = array(
            "id" => $gelenAnketID
        );
        $newData = array(
            "baslik" => $baslik,
            "metin" => $metin,
            "aciklama" => $aciklama,
            "anketKitle" => $gelenAnketKitle,
            "anketGorus" => $gelenAnketGorus,
            "anketGiris" => $gelenAnketGiris,
            "serialize" => $serialize
        );
        $result = $db->table("anketler")->where($data)->update($newData);
        return $result;
    }
    public function setAnketProjectUpdOnay($gelenAnketID, $gelenOnay){
        // ID verisi girilerek güncelleme işlemi yapılabilir. (Email ve Faktor)
        $db = \Config\Database::connect();
        $data = array(
            "id" => $gelenAnketID
        );
        $newData = array(
            "onay" => $gelenOnay
        );
        $result = $db->table("anketler")->where($data)->update($newData);
        return $result;
    }
    public function getMyAnketProjects($gelenYonetici){
        $db = \Config\Database::connect();
        $data = array(
            "yoneticiID" => $gelenYonetici
        );
        $result = $db->table("anketler")->getwhere($data)->getResult();
        return $result;
    }
    public function getAnketProject($gelenID){ // ID değerine göre anket verisi getirilir.
        $db = \Config\Database::connect();
        $data = array(
            "id" => $gelenID
        );
        $result = $db->table("anketler")->getwhere($data)->getRow();
        return $result;
    }
    public function getAnketProjects(){
        $db = \Config\Database::connect();
        $result = $db->table("anketler")->get()->getResult();
        return $result;
    }
    public function setAnketProjectDel($gelenID){ // ID değerine göre anket verisi silinir.
        $db = \Config\Database::connect();
        $data = array(
            "id" => $gelenID
        );
        $result = $db->table("anketler")->delete($data);
        return $result;
    }

    public function setAnketResult($gelenAnketID,$gelenSerialize,$anketGorus, $gelenBrans, $gelenFakulte, $gelenBirim, $gelenIP, $getDate){
        $db = \Config\Database::connect();
        $data = array(
            "anketID"       => $gelenAnketID,
            "serialize"     => $gelenSerialize,
            "anketGorus"    => $anketGorus,
            "bransTur"      => $gelenBrans,
            "fakulteID"     => $gelenFakulte,
            "birimID"       => $gelenBirim,
            "kullaniciIP"   => $gelenIP,
            "gonderimTarihi"   => $getDate
        );
        $result = $db->table("anketcevaplar")->insert($data);
        return $result;
    }
    public function setAnketResultsDel($gelenAnketID){ // Anket cevapları ID değerine göre silinir.
        $db = \Config\Database::connect();
        $data = array(
            "anketID" => $gelenAnketID
        );
        $result = $db->table("anketcevaplar")->delete($data);
        return $result;
    }
    public function getAnketResult($gelenAnketID){
        $db = \Config\Database::connect();
        $data = array(
            "anketID" => $gelenAnketID,
        );
        $result = $db->table("anketcevaplar")->getWhere($data)->getResult();
        return $result;
    }
    public function getAnketResultExcel($gelenAnketID){
        $db = \Config\Database::connect();
        $data = array(
            "anketID" => $gelenAnketID,
        );
        $result = $db->table("anketcevaplar")->orderBy("fakulteID", "ASC")->getWhere($data)->getResult();
        return $result;
    }
    public function getAnketIpReport($gelenAnketID, $gelenIP){ // İp adresiyle önceden anket doldurulmuş mu ona baktık.
        $db = \Config\Database::connect();
        $data = array(
            "anketID" => $gelenAnketID,
            "kullaniciIP" => $gelenIP
        );
        $result = $db->table("anketcevaplar")->getWhere($data)->getRow();
        return $result;
    }
}

?>