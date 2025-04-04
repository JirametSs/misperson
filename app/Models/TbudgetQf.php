<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TbudgetQf extends Model
{
    protected $table = 'tbudget_qf';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'EmployeeType',
        // เพิ่มคอลัมน์อื่น ๆ ตามโครงสร้างจริง
    ];
}
