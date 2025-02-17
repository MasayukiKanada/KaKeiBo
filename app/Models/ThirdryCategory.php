<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThirdryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'secondary_category_id',
    ];
}
