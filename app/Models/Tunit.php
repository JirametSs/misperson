<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Tunit extends Model
{
    protected $table = 'tunit';

    protected $fillable = [
        'name',
        'description'
    ];

    // ความสัมพันธ์กลับไปยังบุคลากร
    public function persons()
    {
        return $this->hasMany(Person::class, 'tunit_id');
    }
}
