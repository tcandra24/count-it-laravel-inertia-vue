<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class PlanDetail extends Model
{
    protected $fillable = [
        'name',
        'qty',
        'price',
        'total',
        'is_active',
        'plan_id'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucwords($value),
        );
    }
}
