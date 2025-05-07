<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['name', 'specialization_id'];

    public function specialization()
    {
        return $this->belongsTo(Specialization::class);
    }

    public function doctorServices()
    {
        return $this->hasMany(DoctorService::class);
    }
}
