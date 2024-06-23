<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Service\StudentService;

class StudentAPI extends Controller
{
    public function createStudent(Request $request)
    {
        $student = (new StudentService)->createStudent($request);
        if (!$student) {
            return response()->json([
                "status" => "failed",
                "msg" => "Something went wrong"
            ]);
        }

        return response()->json([
            "status" => "success",
            "msg" => "Success"
        ]);
    }
    public function getStudent()
    {
        $student = (new StudentService)->getStudent();

        if (!$student->count() > 0) {
            return response()->json([
                "status" => "empty",
                "msg" => "Empty data"
            ]);
        }
        return response()->json([
            "status" => "success",
            "msg" => "Success",
            "students" => $student,
        ]);
    }
    public function  deleteStudent(Request $request)
    {
        $student = (new StudentService)->deleteStudent($request);
        if (!$student) {
            return response()->json([
                "status" => "failed",
                "msg" => "Something went wrong"
            ]);
        }
        return response()->json([
            "status" => "success",
            "msg" => "Success"
        ]);
    }
    public function updateStudent(Request $request)
    {
        try {
            $student = (new StudentService)->updateStudent($request);
            if (!$student) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }
            return response()->json([
                "status" => "success",
                "msg" => "Success"
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
