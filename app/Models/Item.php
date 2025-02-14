<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_category_id',
        'date',
        'partner_id',
        'secondary_category_id',
        'thirdry_category_id',
        'subject_id',
        'price',
    ];
}
