<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSchedule extends Model
{
    protected $dateFormat = 'Ymd H:i:s';
    protected $table = 'available_schedules';

    protected $fillable = [
        'doctor_id',
        'day_of_week',
        'start_time',
        'end_time',
        'consulting_room',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
