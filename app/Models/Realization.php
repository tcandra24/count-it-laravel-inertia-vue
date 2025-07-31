<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Realization extends Model
{
    protected $fillable = [
        'transaction_number',
        'image',
        'month',
        'year',
    ];

    public function detail()
    {
        return $this->hasMany(RealizationDetail::class);
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => url('/storage/realizations/' . $value),
        );
    }

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d-M-Y H:i:s'),
        );
    }
}
