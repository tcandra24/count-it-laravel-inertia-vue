<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    protected $fillable = [
        'plan_id',
        'realization_id',
        'month',
        'year',
        'amount',
        'user_id'
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function realization()
    {
        return $this->belongsTo(Realization::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
