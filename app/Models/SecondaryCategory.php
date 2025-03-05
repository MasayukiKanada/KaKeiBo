<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\PrimaryCategory;
use App\Models\ThirdryCategory;
use SoftDeletes;

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

    public function primary_category() {
        return $this->belongsTo(PrimaryCategory::class);
    }

    public function thirdry_category() {
        return $this->hasMany(ThirdryCategory::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($secondary_category) {
            $secondary_category->thirdry_category()->delete();
        });
    }
}
