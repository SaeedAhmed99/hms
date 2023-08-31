<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRadiology extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'order_radiologies';
    protected $fillable = ['doctor_id', 'patient_id', 'status', 'is_paid', 'original_price', 'price_after_discount', 'other'];


    /**
     * @return HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderRadiologyDetails::class, 'order_radiology_id');
    }

    /**
     * @return BelongsTo
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    /**
     * @return BelongsTo
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    /**
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(Document::class, 'order_radiology_id');
    }
}
