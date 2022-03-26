<?php
namespace App\Models;
use CodeIgniter\Model;

class IslemModel extends Model {
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
    
}

?>