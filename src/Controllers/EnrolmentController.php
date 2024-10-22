<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    public function enrollmentForm()
    {
        $courseObj = new Course();
        $studentObj = new Student();

        $template = 'enrollment-form';
        $data = [
            'courses' => $courseObj->all(),
            'students' => $studentObj->all()
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    public function enroll($course_code, $student_code, $enrolment_date)
    {
        $sql = "INSERT INTO course_enrollments (course_code, student_code, enrolment_date) VALUES (:course_code, :student_code, :enrolment_date)";
        $statement = $this->db->prepare($sql);
        return $statement->execute([
            'course_code' => $course_code,
            'student_code' => $student_code,
            'enrolment_date' => $enrolment_date
        ]);
    }


}