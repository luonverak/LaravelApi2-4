<?php

namespace App\Http\Service;

use App\Http\Controllers\Api\StudentAPI;
use App\Models\StudentModel;
use Illuminate\Http\Request;

class StudentService
{
    public function createStudent(Request $request)
    {
        try {

            if (!$request->has("name") && !$request->has("score") && !$request->has("profile")) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }

            $name = $request->name;
            $score = $request->score;
            $profile = $request->file("profile");
            $fileName = rand(1, 100000) . '-' . $profile->getClientOriginalName();
            $profile->move('images', $fileName);

            $student = StudentModel::create([
                "stu_name" => $name,
                "stu_score" => $score,
                "stu_profile" => $fileName
            ]);
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
    public function getStudent()
    {
        try {
            $student = StudentModel::select("stu_name as name", "stu_score as score", "stu_profile as profile")->get();

            if (!$student) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }

            $records = $student->map(function ($row) {
                return [
                    "name" => $row->name,
                    "score" => $row->score,
                    "profile" => url("images/$row->profile")
                ];
            });

            return response()->json([
                "status" => "success",
                "msg" => "Success",
                "students" => $records,
            ]);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteStudent(Request $request)
    {
        try {
            if (!$request->has("stu_id")) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }
            $id = $request->stu_id;
            $student = StudentModel::where("id", $id)->delete();
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
            //throw $th;
        }
    }
}
