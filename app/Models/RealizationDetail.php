<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class RealizationDetail extends Model
{
    protected $fillable = [
        'realization_id',
        'plan_detail_id',
        'budget_detail_id',
        'unit_id',
        'qty',
        'price',
        'total',
        'note',
    ];

    public function plan_detail()
    {
        return $this->belongsTo(PlanDetail::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function budget_detail()
    {
        return $this->belongsTo(BudgetDetail::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
            get: fn ($value) => ucwords($value),
        );
    }
}
