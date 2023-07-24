<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class labCategory extends Model
{
    use HasFactory;

    protected $table = 'lab_categories';
    protected $fillable = ['name', 'description'];

    /**
     * @return HasMany
     */
    public function labs()
    {
        return $this->hasMany(labCategoryAddType::class, 'category_id');
    }
}
