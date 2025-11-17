<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'license_number',
        'specialty_id',
        'email',
        'phone',
        'office',
        'schedule',
        'experience_years',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'experience_years' => 'integer',
    ];

    /**
     * Accessor para nombre completo
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Relación: Un médico pertenece a una especialidad
     */
    public function specialty()
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * Relación: Un médico tiene muchas citas
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Scope para médicos disponibles
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_available', true);
    }
}
