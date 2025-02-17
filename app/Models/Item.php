<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Partner;
use App\Models\Subject;
use App\Models\PrimaryCategory;
use App\Models\SecondaryCategory;
use App\Models\ThirdryCategory;

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
        'user_id',
    ];

    public function users() {
        return $this->belongsTo(User::class);
    }

    public function partners() {
        return $this->belongsTo(Partner::class);
    }

    public function subjects() {
        return $this->belongsTo(Subject::class);
    }

    public function primary_categories() {
        return $this->belongsTo(PrimaryCategory::class);
    }

    public function secondary_categories() {
        return $this->belongsTo(SecondaryCategory::class);
    }

    public function thirdry_categories() {
        return $this->belongsTo(ThirdryCategory::class);
    }
}
