<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    public function find($code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = :code";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':code', $code, PDO::PARAM_STR);
        $statement->execute();
        
        return $statement->fetchObject('\App\Models\Course') ?: null; 
    }

    public function all()
    {
        $sql = "
            SELECT 
                c.*, 
                COUNT(ce.student_code) AS enrolled_students
            FROM 
                courses c
            LEFT JOIN 
                course_enrollments ce ON c.course_code = ce.course_code
            GROUP BY 
                c.course_code
        ";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
    }

    public function getEnrolees($course_code)
    {
        $sql = "
            SELECT 
                s.*
            FROM 
                course_enrollments AS ce
            LEFT JOIN 
                students AS s ON s.student_code = ce.student_code
            WHERE 
                ce.course_code = :course_code
        ";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':course_code', $course_code, PDO::PARAM_STR);
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
    }
}