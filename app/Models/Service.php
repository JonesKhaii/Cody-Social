<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image',
        'is_active'
    ];

    /**
     * Các thuộc tính được ép kiểu
     *
     * @var array
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Lấy URL thân thiện cho service
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Lấy đường dẫn đến ảnh dịch vụ
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/services/' . $this->image);
        }
        return null;
    }

    /**
     * Lấy đường dẫn đến icon dịch vụ
     *
     * @return string|null
     */
    public function getIconUrlAttribute()
    {
        if ($this->icon) {
            return asset('storage/services/icons/' . $this->icon);
        }
        return null;
    }

    /**
     * Quan hệ với các bác sĩ cung cấp dịch vụ này
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_services')
            ->withPivot('price', 'description')
            ->withTimestamps();
    }

    /**
     * Quan hệ với bảng trung gian doctor_services
     */
    public function doctorServices()
    {
        return $this->hasMany(DoctorService::class);
    }

    /**
     * Scope cho dịch vụ đang hoạt động
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
