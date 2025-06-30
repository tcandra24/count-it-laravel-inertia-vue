<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

// Models
use App\Models\Budget;

// Requests
use App\Http\Requests\StoreBudgetRequest;
use App\Http\Requests\UpdateBudgetRequest;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $budgets = Budget::all();

        return Inertia::render('transaction/budgets/Index', ['budgets' => $budgets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('transaction/budgets/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBudgetRequest $request)
    {
        try {
            Budget::create([
                'month' => $request->month,
                'year' => $request->year,
                'initial_balance' => $request->initial_balance,
            ]);

            return redirect()->route('budgets.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Budget $budget)
    {
         return Inertia::render('transaction/budgets/Edit', ['budget' => $budget]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBudgetRequest $request, Budget $budget)
    {
        try {
            $budget->update([
                'month' => $request->month,
                'year' => $request->year,
                'initial_balance' => $request->initial_balance,
            ]);

            return redirect()->route('budgets.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Budget $budget)
    {
        try {
            $budget->delete();

            return redirect()->route('budgets.index');
        } catch (\Exception $e) {
            return back();
        }
    }
}
