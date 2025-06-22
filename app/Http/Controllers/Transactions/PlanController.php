<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

// Models
use App\Models\Plan;
use App\Models\PlanDetail;

// Requests
use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = Plan::with(['user'])->get();

        return Inertia::render('plans/Index', ['plans' => $plans]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('plans/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePlanRequest $request)
    {
        try {
            DB::transaction(function() use ($request){
                $plan = Plan::create([
                    'month' => $request->month,
                    'year' => $request->year,
                    'user_id' => Auth::user()->id,
                ]);

                $detail = collect($request->details)->map(function ($detail) use ($plan) {
                    return [
                        'plan_id' => $plan->id,
                        'name' => $detail['name'],
                        'qty' => $detail['qty'],
                        'price' => $detail['price'],
                        'total' => $detail['qty'] * $detail['price'],
                    ];
                })->toArray();

                PlanDetail::insert($detail);
            });

            return redirect()->route('plans.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Plan $plan)
    {
        $plan->load(['detail']);
        return Inertia::render('plans/Show', ['plan' => $plan]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Plan $plan)
    {
        $plan->load(['detail']);
        return Inertia::render('plans/Edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        try {
            DB::transaction(function() use ($request, $plan){
                $plan->update([
                    'month' => $request->month,
                    'year' => $request->year,
                    'user_id' => Auth::user()->id,
                ]);

                $requestDetailId = collect($request->details)->pluck('id')->toArray();

                $plan->detail()->whereNotIn('id', $requestDetailId)->delete();

                $details = collect($request->details)->map(function ($detail) use ($plan) {

                    return [
                        'id' => $detail['id'],
                        'plan_id' => $plan->id,
                        'name' => $detail['name'],
                        'qty' => $detail['qty'],
                        'price' => $detail['price'],
                        'total' => $detail['qty'] * $detail['price'],
                    ];
                })->toArray();

                PlanDetail::upsert($details, ['id', 'plan_id'], ['name', 'qty', 'price', 'total']);
            });

            return redirect()->route('plans.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();

            return redirect()->route('plans.index');
        } catch (\Exception $e) {
            return back();
        }
    }
}
