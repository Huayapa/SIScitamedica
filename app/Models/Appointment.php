<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_date',
        'appointment_time',
        'status',
        'reason',
        'notes',
        'diagnosis',
    ];

    protected $casts = [
        'appointment_date' => 'date',
    ];

    /**
     * Relación: Una cita pertenece a un paciente
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Relación: Una cita pertenece a un médico
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    /**
     * Scope para citas de hoy
     */
    public function scopeToday($query)
    {
        return $query->whereDate('appointment_date', today());
    }

    /**
     * Scope para citas confirmadas
     */
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    /**
     * Scope para citas pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope para citas canceladas
     */
    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    /**
     * Obtener badge de estado
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'confirmed' => '<span class="inline-flex items-center gap-1 px-2 py-1 bg-green-900 text-green-300 rounded-full text-xs">Confirmada</span>',
            'pending' => '<span class="inline-flex items-center gap-1 px-2 py-1 bg-yellow-900 text-yellow-300 rounded-full text-xs">Pendiente</span>',
            'cancelled' => '<span class="inline-flex items-center gap-1 px-2 py-1 bg-red-900 text-red-300 rounded-full text-xs">Cancelada</span>',
            'completed' => '<span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-900 text-blue-300 rounded-full text-xs">Completada</span>',
            default => '<span class="inline-flex items-center gap-1 px-2 py-1 bg-slate-700 text-slate-300 rounded-full text-xs">Desconocido</span>',
        };
    }
}
