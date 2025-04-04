<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tprefix extends Model
{
    protected $table = 'tprefix'; // ชื่อตารางคำนำหน้า

    protected $fillable = [
        'short_name', // เช่น "นาย", "นางสาว"
        'full_name'   // เช่น "นาย", "นางสาว", "คุณ", เป็นต้น
    ];

    // ความสัมพันธ์กลับไปยังบุคลากร
    public function persons()
    {
        return $this->hasMany(Person::class, 'prefix_id');
    }
}
