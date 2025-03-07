<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\SecondaryCategory;

class PrimaryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function item() {
        return $this->hasMany(Item::class);
    }

    public function secondary_category() {
        return $this->hasMany(SecondaryCategory::class);
    }
}
