<?php
namespace App\Models;
use CodeIgniter\Model;

class IslemModel extends Model {
    public function getControlMembers($degree){
        $db = \Config\Database::connect();
        $data = array(
            "emailAdresi" => $degree
        );
        $result = $db->table("uyeler")->getWhere($data)->getRow();
        return $result;
    }
}

?>