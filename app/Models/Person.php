<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    // กำหนดชื่อ table ที่ใช้ในฐานข้อมูล
    protected $table = 'temployee_qf';

    // กำหนด primary key ของตารางนี้ (ใช้ 'idx' แทน 'id')
    protected $primaryKey = 'idx';

    // ระบุว่า primary key นี้ไม่ใช่ auto-increment
    public $incrementing = false;

    // ปิดการใช้งาน timestamps (created_at, updated_at)
    public $timestamps = false;

    // ฟิลด์ที่สามารถกำหนดค่าได้แบบ mass assignment
    protected $fillable = [
        'prefix_id',       // รหัสคำนำหน้า
        'fname',           // ชื่อจริง
        'lname',           // นามสกุล
        'Tunit_id',        // รหัสหน่วยงาน
        'T_Work_id',       // รหัสที่ทำงานหลัก
        'T_Worku_id',      // รหัสที่ทำงานย่อย
        'TJob_id',         // รหัสประเภทการจ้าง
        'Tpos_id',         // รหัสตำแหน่ง
        'budget',          // รหัสงบประมาณ
        'tel',             // เบอร์โทรศัพท์
        'email_cmu',       // อีเมล มช.
    ];

    // ---------------------
    // ความสัมพันธ์กับตารางอื่น
    // ---------------------

    // ความสัมพันธ์: คำนำหน้า (prefix_id -> id ในตาราง Tprefix)
    public function prefix()
    {
        return $this->belongsTo(Tprefix::class, 'prefix_id', 'id');
    }

    // ความสัมพันธ์: ตำแหน่ง (Tpos_id -> id ในตาราง Tposition)
    public function position()
    {
        return $this->belongsTo(\App\Models\Tposition::class, 'Tpos_id', 'old_pos_id');
    }


    // ความสัมพันธ์: ประเภทการจ้าง (TJob_id -> id ในตาราง Tjob)
    public function job()
    {
        return $this->belongsTo(Tjob::class, 'TJob_id', 'id');
    }

    // ความสัมพันธ์: หน่วยงาน (Tunit_id -> id ในตาราง Tunit)
    public function unit()
    {
        return $this->belongsTo(Tunit::class, 'Tunit_id', 'id');
    }
    public function budgetQf()
    {
        return $this->belongsTo(TbudgetQf::class, 'budget', 'id');
    }

    public function tunit()
    {
        return $this->belongsTo(Tunit::class, 'T_Worku_id');
    }

    public function tjob()
    {
        return $this->belongsTo(Tjob::class, 'T_Work_id');
    }


    // ---------------------
    // Accessor สำหรับดึงชื่อเต็ม
    // ---------------------

    // ฟังก์ชันช่วยในการเรียกชื่อเต็ม (คำนำหน้า + ชื่อ + นามสกุล)
    public function getFullNameAttribute()
    {
        // ตรวจสอบว่าได้โหลดข้อมูลคำนำหน้าไว้แล้วหรือยัง
        $prefix = $this->relationLoaded('prefix') ? ($this->prefix->short_name ?? '') : '';
        return trim("$prefix {$this->fname} {$this->lname}");
    }
}
