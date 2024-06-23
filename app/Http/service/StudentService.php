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

            if (!$request->has("name") && !$request->has("score") && !$request->file("profile")) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }

            $profile = $request->profile;
            $fileName = rand(1, 100000) . '-' . $profile->getClientOriginalName();
            $profile->move('images', $fileName);

            $student = StudentModel::create([
                "stu_name" => $request->name,
                "stu_score" => $request->score,
                "stu_profile" => $fileName
            ]);
            return $student;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getStudent()
    {
        try {
            $student = StudentModel::select("id", "stu_name as name", "stu_score as score", "stu_profile as profile")->get();

            if (!$student) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }

            $records = $student->map(function ($row) {
                return [
                    "id" => $row->id,
                    "name" => $row->name,
                    "score" => $row->score,
                    "profile" => url("images/$row->profile")
                ];
            });
            return $records;
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
            return  $student;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateStudent(Request $request)
    {
        try {
            if (!$request->has("stu_id")) {
                return response()->json([
                    "status" => "failed",
                    "msg" => "Something went wrong"
                ]);
            }

            $id = $request->stu_id;

            $studentOldData = StudentModel::where('id', $id)->first();

            $name = $request->name ?? $studentOldData->stu_name;
            $score = $request->score ?? $studentOldData->stu_score;

            $fileName = "";
            $profile = $request->file("profile");
            if ($profile) {
                $fileName = rand(1, 100000) . '-' . $profile->getClientOriginalName();
                $profile->move('images', $fileName);
            }else{
                $fileName = $studentOldData->stu_profile;
            }

            $student = StudentModel::where('id', $id)->update(
                [
                    "stu_name" => $name,
                    "stu_score" => $score,
                    "stu_profile" => $fileName
                ]
            );
            return  $student;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
