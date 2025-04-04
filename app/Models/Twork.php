<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Twork extends Model
{
    protected $table = 'twork'; // ตารางที่ทำงานหลัก

    protected $fillable = [
        'name',
        'description'
    ];

    public function persons()
    {
        return $this->hasMany(Person::class, 't_work_id');
    }
}
