<?php

use App\Http\Controllers\Api\StudentAPI;
use Illuminate\Support\Facades\Route;

Route::post("/creat-student",[StudentAPI::class,'createStudent']);
Route::post("/student",[StudentAPI::class,'getStudent']);
Route::post("/delete/student",[StudentAPI::class,'deleteStudent']);
Route::post("/upate/student",[StudentAPI::class,'updateStudent']);
