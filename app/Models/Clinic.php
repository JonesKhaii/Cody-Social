<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
        'slug',
        'created_at',
        'updated_at'
    ];

    /**
     * Boot model
     */
    protected static function boot()
    {
        parent::boot();

        // Tự động tạo slug khi tạo mới
        static::creating(function ($clinic) {
            if (!$clinic->slug) {
                $clinic->slug = Str::slug($clinic->name);
            }
        });

        // Tự động cập nhật slug khi cập nhật tên
        static::updating(function ($clinic) {
            if ($clinic->isDirty('name') && !$clinic->isDirty('slug')) {
                $clinic->slug = Str::slug($clinic->name);
            }
        });
    }

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

    /**
     * Relationship với bảng doctors
     */
    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'doctor_clinics');
    }

    /**
     * Get clinic by slug
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->firstOrFail();
    }

    public function treatmentPosts()
    {
        return $this->belongsToMany(Post::class, 'clinic_post')
            ->withPivot('notes')
            ->withTimestamps();
    }
}
