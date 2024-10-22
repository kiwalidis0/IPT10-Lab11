<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{
    public function find($id)
    {
        $sql = "SELECT * FROM students WHERE id = :id"; 
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        
        $student = $statement->fetchObject('\App\Models\Student');
        
        return $student ?: null;
    }

    public function all()
    {
        $sql = "SELECT * FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    }
}