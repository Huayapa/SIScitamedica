<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relación: Una especialidad tiene muchos médicos
     */
    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
