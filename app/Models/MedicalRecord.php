<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $table = 'medical_records';
    protected $fillable = [
        'appointment_id',
        'diagnosis',
        'medical_notes',
        'prescription',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
