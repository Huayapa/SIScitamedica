<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $fillable = [
        'code',
        'first_name',
        'last_name',
        'document_number',
        'birth_date',
        'gender',
        'email',
        'phone',
        'address',
        'blood_type',
        'allergies',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Accessor para nombre completo
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Accessor para edad
     */
    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->age;
    }

    /**
     * Relación: Un paciente tiene muchas citas
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * Obtener última visita
     */
    public function getLastVisitAttribute()
    {
        $lastAppointment = $this->appointments()
            ->where('status', 'completed')
            ->orderBy('appointment_date', 'desc')
            ->first();
            
        return $lastAppointment ? $lastAppointment->appointment_date : null;
    }
}
