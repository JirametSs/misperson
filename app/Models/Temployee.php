<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Temployee extends Model
{
    protected $table = 'temployee_qf';
    protected $primaryKey = 'idx';
    public $timestamps = false;

    protected $fillable = ['idx', 'budget'];

    public function budget()
    {
        return $this->belongsTo(Tbudget::class, 'budget', 'id')->withDefault([
            'name' => 'ไม่ระบุ',
            'id' => 0
        ]);
    }
}
