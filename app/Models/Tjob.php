<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tjob extends Model
{
    protected $table = 'tjob'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'name',         // เช่น "ข้าราชการ", "พนักงานราชการ"
        'description',   // (ถ้ามี) คำอธิบายเพิ่มเติม
        'EmployeeType',
    ];

    // ความสัมพันธ์ย้อนกลับ: ตำแหน่งนี้มีบุคลากรหลายคน
    public function persons()
    {
        return $this->hasMany(Person::class, 'tjob_id');
    }
}
