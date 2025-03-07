<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\SecondaryCategory;

class ThirdryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'secondary_category_id',
    ];

    public function item() {
        return $this->hasMany(Item::class);
    }

    public function secondary_category() {
        return $this->belongsTo(SecondaryCategory::class);
    }
}
