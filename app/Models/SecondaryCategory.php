<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class SecondaryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'primary_category_id',
    ];

    public function item() {
        return $this->hasMany(Item::class);
    }
}
