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
    public function getControlMembers(){
        $db = \Config\Database::connect();
        $result = $db->table("uyeler")->get()->getResult();
        return $result;
    }
}

?>