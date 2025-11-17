<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $fillable = [
        'specialty_name',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
