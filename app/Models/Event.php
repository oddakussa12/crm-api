<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover_image',
        'title',
        'description',
        'start_date',
        'end_date',
        'is_limited',
        'is_public',
        'available_spots',
        'is_archived'

    ];
}
