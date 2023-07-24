<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderLabDetails extends Model
{
    use HasFactory;
    protected $table = 'order_lab_details';
    protected $fillable = ['order_lab_id', 'lab_type_id'];


    /**
     * @return BelongsTo
     */
    public function lab_type()
    {
        return $this->belongsTo(labCategoryAddType::class, 'lab_type_id');
    }

}
