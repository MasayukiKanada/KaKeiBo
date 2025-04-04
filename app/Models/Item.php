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
        'memo',
        'user_id',
    ];

    public function scopeYearMonth($query, $year = null, $month = null)
    {
        if(is_null($year) && is_null($month)) {
            return $query;
        }

        if(isset($year) && is_null($month)) {
            return $query->whereYear('date', $year);
        }

        if(isset($year) && isset($month)) {
            return $query->whereYear('date', $year)->whereMonth('date', $month);
        }
    }

    public function scopeCategoryPartner($query, $category = null, $partner = null)
    {
        if(is_null($category) && is_null($partner)) {
            return $query;
        }

        if(isset($category) && is_null($partner)) {
            return $query->where('secondary_category_id', $category);
        }

        if(is_null($category) && isset($partner)) {
            return $query->where('partner_id', $partner);
        }
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function partner() {
        return $this->belongsTo(Partner::class);
    }

    public function subject() {
        return $this->belongsTo(Subject::class);
    }

    public function primary_category() {
        return $this->belongsTo(PrimaryCategory::class);
    }

    public function secondary_category() {
        return $this->belongsTo(SecondaryCategory::class);
    }

    public function thirdry_category() {
        return $this->belongsTo(ThirdryCategory::class);
    }
}
