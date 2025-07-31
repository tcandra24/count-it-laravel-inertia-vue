<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetDetail extends Model
{
    protected $fillable = [
        'budget_id',
        'name',
        'precentage',
        'nominal'
    ];

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
