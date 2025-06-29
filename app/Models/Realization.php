<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Realization extends Model
{
    protected $fillable = [
        'plan_detail_id',
        'name',
        'qty',
        'price',
        'total',
        'image',
        'month',
        'year',
    ];

    public function plan_detail()
    {
        return $this->belongsTo(PlanDetail::class);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => strtolower($value),
            get: fn ($value) => ucwords($value),
        );
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('/storage/realization/' . $value),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i:s'),
        );
    }
}
