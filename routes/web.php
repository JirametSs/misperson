<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

//หน้าแรก
Route::get('/', function () {
    return view('welcome');
});

//หน้าเช็คว่าฐานข้อมูลต่อเข้ากับ Database แล้วหรือไม่
Route::get('/check-db', function () {
    try {
        DB::connection()->getPdo();
        $status = "✅ Connected to database: " . DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        $status = "❌ Database connection failed: " . $e->getMessage();
    }
    return view('config', ['status' => $status]);
});

//หน้าข้อมูลโครงสร้าง
Route::get('/structure', [App\Http\Controllers\StructureController::class, 'index']);

//หน้าข้อมูลงบประมาณ
Route::get('/job', [App\Http\Controllers\JobController::class, 'index']);

//หน้าข้อมูลบุคลากร
Route::get('/person_detail', [App\Http\Controllers\PersondetailController::class, 'index']);

//หน้าข้อมูลบุคลากรทั้งหมด
Route::get('/person_detail/persons', [App\Http\Controllers\PersonController::class, 'index']);

Route::get('/person/{id}', [App\Http\Controllers\PersonController::class, 'show']);

Route::get('/person_detail/person', [App\Http\Controllers\PersonalController::class, 'show']);
