<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymSchedule extends Model
{
    use HasFactory;

    protected $fillable = ['day', 'time', 'class_type', 'description'];

    // Optionally define relationships here if needed
}