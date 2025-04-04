<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tposition extends Model
{
    protected $table = 'tposition'; // ชื่อตารางในฐานข้อมูล

    protected $fillable = [
        'name',       // ชื่อตำแหน่ง เช่น "พยาบาลวิชาชีพชำนาญการ"
        'description' // (ถ้ามี) คำอธิบายตำแหน่ง
    ];

    // ความสัมพันธ์ย้อนกลับ (ถ้าอยากใช้จาก Tposition -> Persons)
    public function persons()
    {
        return $this->hasMany(Person::class, 'Tpos_id');
    }
}
