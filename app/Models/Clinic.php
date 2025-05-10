<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong database
     *
     * @var string
     */
    protected $table = 'clinics';

    /**
     * Các trường có thể gán hàng loạt
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'photo',
        'type',
        'created_at',
        'updated_at'
    ];

    /**
     * Scope lấy ra các bệnh viện
     */
    public function scopeHospitals($query)
    {
        return $query->where('type', 'Bệnh viện');
    }

    /**
     * Scope lấy ra các phòng khám
     */
    public function scopeClinicsOnly($query)
    {
        return $query->where('type', 'Phòng khám');
    }

    public function getPhotoUrlAttribute()
    {
        if (!$this->photo) {
            return null;
        }

        // Nếu là URL đầy đủ
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }

        // Nếu là đường dẫn relative
        return asset('storage/' . $this->photo);
    }


    // public function reviews()
    // {
    //     return $this->hasMany(Review::class, 'clinic_id');
    // }


    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }


    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_clinics');
    }
}
