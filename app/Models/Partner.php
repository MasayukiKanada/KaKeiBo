<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function scopeSearchPartners($query, $input = null)
    {
        if(!empty($input)) {
            if(Partner::where('name', 'like', $input . '%')
            ->exists())
            {
                return $query->where('name', 'like', $input . '%');
            }
        }
    }

    public function item() {
        return $this->hasMany(Item::class);
    }
}
