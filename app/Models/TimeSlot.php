<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $table = 'time_slots';

    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'label',
    ];

    public $timestamps = false;

    public function doctorTimeSlots()
    {
        return $this->hasMany(DoctorTimeSlot::class);
    }
}
