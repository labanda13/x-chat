<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blacklist extends Model
{
    use HasFactory;

    protected $casts = [
        'free_at' => 'datetime'
    ];

    protected $fillable = [
        'ip'
    ];
}
