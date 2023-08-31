<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderRadiologyDetails extends Model
{
    use HasFactory;
    protected $table = 'order_radiology_details';
    protected $fillable = ['order_radiology_id', 'radiology_type_id'];


    /**
     * @return BelongsTo
     */
    public function radiology_type()
    {
        return $this->belongsTo(radiologyCategoryAddType::class, 'radiology_type_id');
    }
}
