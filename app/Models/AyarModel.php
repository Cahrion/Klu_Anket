<?php
namespace App\Models;
use CodeIgniter\Model;

class AyarModel extends Model {
    public function get_Ayars($degree){
        $db = \Config\Database::connect();
        $result = $db->table("ayarlar")->get()->getRow();
        return $result->$degree;
    }
}

?>