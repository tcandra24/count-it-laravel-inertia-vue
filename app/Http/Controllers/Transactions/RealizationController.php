<?php

namespace App\Http\Controllers\Transactions;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Carbon\Carbon;

// Models
use App\Models\Plan;
use App\Models\Budget;
use App\Models\Unit;
use App\Models\PlanDetail;
use App\Models\Realization;
use App\Models\RealizationDetail;

// Requests
use App\Http\Requests\StoreRealizationRequest;
use App\Http\Requests\UpdateRealizationRequest;

class RealizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $realizations = Realization::all();

        return Inertia::render('transaction/realizations/Index', ['realizations' => $realizations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $plans = Plan::with(['detail'])
            ->where('month', $now->month)
            ->where('year', $now->year)
            ->get();
        $budgets = Budget::with(['detail'])
            ->where('month', $now->month)
            ->where('year', $now->year)
            ->get();

        $units = Unit::all();

        return Inertia::render('transaction/realizations/Create', [
            'plans' => $plans,
            'budgets' => $budgets,
            'units' => $units,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRealizationRequest $request)
    {
        try {
            DB::transaction(function() use ($request){
                $image = $request->file('image');
                $image->storeAs('realizations', $image->hashName(), 'public');

                // Generate Code Realization
                $now = Carbon::now();
                $month = $now->format('m');
                $year = $now->year;
                $count = Realization::count() + 1;
                $transactionNumber = 'REALIZATION/' . $month . $year . '/' . str_pad($count, 4, '0', STR_PAD_LEFT);
                // End

                $realization = Realization::create([
                    'transaction_number' => $transactionNumber,
                    'image' => $image->hashName(),
                    'month' => $request->month,
                    'year' => $request->year,
                ]);

                $details = collect($request->details)->map(function ($detail) use ($realization) {
                    return [
                        'realization_id' => $realization->id,
                        'plan_detail_id' => $detail['plan_detail_id'],
                        'budget_detail_id' => $detail['budget_detail_id'],
                        'unit_id' => $detail['unit_id'],
                        'note' => $detail['note'],
                        'qty' => $detail['qty'],
                        'price' => $detail['price'],
                        'total' => $detail['qty'] * $detail['price'],
                    ];
                })->toArray();

                RealizationDetail::insert($details);
            });

            return redirect()->route('realizations.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Realization $realization)
    {
        $realization->load(['detail', 'detail.plan_detail', 'detail.plan_detail.plan', 'detail.plan_detail.plan.category', 'detail.unit', 'detail.budget_detail']);
        return Inertia::render('transaction/realizations/Show', ['realization' => $realization]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Realization $realization)
    {
        $realization->load(['detail']);
        $now = Carbon::now();
        $plans = Plan::with(['detail'])
            ->where('month', $now->month)
            ->where('year', $now->year)
            ->get();
        $budgets = Budget::with(['detail'])
            ->where('month', $now->month)
            ->where('year', $now->year)
            ->get();


        $units = Unit::all();

        return Inertia::render('transaction/realizations/Edit', [
            'plans' => $plans,
            'realization' => $realization,
            'budgets' => $budgets,
            'units' => $units,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRealizationRequest $request, Realization $realization)
    {
        try {
            DB::transaction(function() use ($request, $realization){
                $data = [
                    'month' => $request->month,
                    'year' => $request->year,
                ];

                if($request->file('image')){
                    Storage::disk('public')->delete('realizations/' . basename($realization->image));

                    $image = $request->file('image');
                    $image->storeAs('realizations', $image->hashName(), 'public');

                    $data['image'] = $image->hashName();
                }

                $realization->update($data);

                $details = collect($request->details)->map(function ($detail) use ($realization) {
                    return [
                        'id' => $detail['id'],
                        'realization_id' => $realization->id,
                        'plan_detail_id' => $detail['plan_detail_id'],
                        'budget_detail_id' => $detail['budget_detail_id'],
                        'unit_id' => $detail['unit_id'],
                        'note' => $detail['note'],
                        'qty' => $detail['qty'],
                        'price' => $detail['price'],
                        'total' => $detail['qty'] * $detail['price'],
                    ];
                })->toArray();

                RealizationDetail::upsert($details, ['id', 'realization_id'], [
                    'plan_detail_id', 'budget_detail_id', 'unit_id', 'note', 'qty', 'price', 'total'
                ]);
            });

            return redirect()->route('realizations.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Realization $realization)
    {
        try {
            Storage::disk('public')->delete('realizations/' . basename($realization->image));
            $realization->delete();
        } catch (\Exception $e) {
            return back();
        }
    }
}
