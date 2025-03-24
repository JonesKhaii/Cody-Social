<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateClick extends Model
{
    protected $fillable = [
        'doctor_id',
        'product_id',
        'hash_ref',
        'ip_address',
        'user_agent',
    ];




    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
