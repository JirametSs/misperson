<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tworku extends Model
{
    protected $table = 'tworku'; // ตารางที่ทำงานย่อย

    protected $fillable = [
        'name',
        'description'
    ];

    public function persons()
    {
        return $this->hasMany(Person::class, 't_worku_id');
    }
}
