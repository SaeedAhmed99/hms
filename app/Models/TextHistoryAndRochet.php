<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextHistoryAndRochet extends Model
{
    use HasFactory;
    protected $table = 'text_history_and_rochets';
    protected $fillable = ['patient_id', 'doctor_id', 'history', 'rochet'];
}
