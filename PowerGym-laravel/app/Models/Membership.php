<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membership extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'memberships';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'membership_type',
        'paid',
    ];

    protected $dates = ['deleted_at'];
}
