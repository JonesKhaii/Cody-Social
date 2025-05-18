<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as LaravelAuthenticatable;
use App\Helpers\BioFormatter;
use App\Models\Category;

class Doctor extends Model implements Authenticatable
{
    use Notifiable, HasFactory, LaravelAuthenticatable;

    protected $table = 'doctors';
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'experience',
        'working_hours',
        'location',
        'phone',
        'email',
        'photo',
        'status',
        'rating',
        'bio',
        'services',
        'workplace',
        'education',
        'consultation_fee',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'working_hours' => 'array',
        'status' => 'boolean',
        'rating' => 'float',
        'consultation_fee' => 'decimal:2',
    ];

    protected $appends = [
        'specialization_list',  // Thêm thuộc tính tự động
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctorID', 'id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'added_by');
    }

    public function getFormattedBioAttribute()
    {
        return BioFormatter::format($this->bio);
    }

    /**
     * Lấy danh sách chuyên khoa dưới dạng chuỗi
     */
    public function getSpecializationListAttribute()
    {
        return $this->specializations->pluck('name')->implode(', ');
    }

    /**
     * Quan hệ với bảng categories thông qua bảng trung gian doctor_specializations
     */
    public function specializations()
    {
        return $this->belongsToMany(Category::class, 'doctor_specializations', 'doctor_id', 'specialization_id')
            ->where('categories.type', 'specialist');
    }

    public function timeSlots()
    {
        return $this->hasManyThrough(
            TimeSlot::class,
            DoctorTimeSlot::class,
            'doctor_id',
            'id',
            'id',
            'time_slot_id'
        );
    }

    public function doctorTimeSlots()
    {
        return $this->hasMany(DoctorTimeSlot::class, 'doctor_id', 'id');
    }
    public function isAdmin()
    {
        return false;
    }
}
