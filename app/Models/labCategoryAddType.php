<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labCategoryAddType extends Model
{
    use HasFactory;
    protected $table = 'lab_category_add_types';
    protected $fillable = ['name', 'code', 'price', 'category_id'];
    

    
}
