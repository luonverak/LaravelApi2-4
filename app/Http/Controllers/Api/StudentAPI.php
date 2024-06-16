<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Service\StudentService;
class StudentAPI extends Controller
{
    public function createStudent(Request $request){
        $studentService = (new StudentService)->createStudent($request);
        return $studentService;
    }
    public function getStudent(){
        $studentService = (new StudentService)->getStudent();
        return $studentService;
    }
}
