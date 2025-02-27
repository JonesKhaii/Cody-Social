<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    use HasFactory;

    protected $table = 'affiliate_links'; // Tên bảng trong database

    protected $fillable = [
        'doctor_id',
        'product_id',
        'affiliate_code',
    ];

    /**
     * Quan hệ với bảng Doctors (Bác sĩ)
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * Quan hệ với bảng Products (Sản phẩm)
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
