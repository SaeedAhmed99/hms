<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoardHistoryAndRochet extends Model
{
    use HasFactory;
    protected $table = 'board_history_and_rochets';
    protected $fillable = ['doctor_id', 'patient_id', 'link', 'type'];
}
