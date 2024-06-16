<?php

use App\Http\Controllers\Api\StudentAPI;
use Illuminate\Support\Facades\Route;

Route::post("/creat-student",[StudentAPI::class,'createStudent']);
Route::post("/student",[StudentAPI::class,'getStudent']);
