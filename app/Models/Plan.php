<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Plan extends Model
{
    protected $fillable = [
        'category_id',
        'month',
        'year',
        'is_active',
        'user_id'
    ];

    public function detail()
    {
        return $this->hasMany(PlanDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i:s'),
        );
    }
}
