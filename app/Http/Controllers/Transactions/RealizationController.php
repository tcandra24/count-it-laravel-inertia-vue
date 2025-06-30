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
use App\Models\PlanDetail;
use App\Models\Realization;

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
        $realizations = Realization::with(['plan_detail', 'plan_detail.plan', 'plan_detail.plan.user', 'plan_detail.plan.category'])->get();

        return Inertia::render('transaction/realizations/Index', ['realizations' => $realizations]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $now = Carbon::now();
        $plans = Plan::with(['detail'])
            ->where('year', $now->year)
            ->get();

        return Inertia::render('transaction/realizations/Create', ['plans' => $plans]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRealizationRequest $request)
    {
        try {
            DB::transaction(function() use ($request){
                $now = Carbon::now();

                $plan_detial_id = null;
                $month = $now->month;
                $year = $now->year;
                if($request->filled('plan_detail_id')){
                    $plan_detial_id = $request->plan_detail_id;
                    $detail = PlanDetail::with(['plan'])->where('id', $request->plan_detail_id)->first();

                    $month = $detail->plan->month;
                    $year = $detail->plan->year;
                }

                $image = $request->file('image');
                $image->storeAs('realizations', $image->hashName(), 'public');

                Realization::create([
                    'plan_detail_id' => $plan_detial_id,
                    'name' => $request->name,
                    'note' => $request->note,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'total' => $request->qty * $request->price,
                    'image' => $image->hashName(),
                    'month' => $month,
                    'year' => $year,
                ]);
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
        $realization->load(['plan_detail', 'plan_detail.plan', 'plan_detail.plan.category']);
        return Inertia::render('transaction/realizations/Show', ['realization' => $realization]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Realization $realization)
    {
        $now = Carbon::now();
        $plans = Plan::with(['detail'])
            ->where('year', $now->year)
            ->get();

         return Inertia::render('transaction/realizations/Edit', ['plans' => $plans, 'realization' => $realization]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRealizationRequest $request, Realization $realization)
    {
        try {
            DB::transaction(function() use ($request, $realization){
                $now = Carbon::now();

                $plan_detial_id = null;
                $month = $now->month;
                $year = $now->year;
                if($request->filled('plan_detail_id')){
                    $plan_detial_id = $request->plan_detail_id;
                    $detail = PlanDetail::with(['plan'])->where('id', $request->plan_detail_id)->first();

                    $month = $detail->plan->month;
                    $year = $detail->plan->year;
                }

                $data = [
                    'plan_detail_id' => $plan_detial_id,
                    'name' => $request->name,
                    'note' => $request->note,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'total' => $request->qty * $request->price,
                    'month' => $month,
                    'year' => $year,
                ];

                if($request->file('image')){
                    Storage::disk('public')->delete('realizations/' . basename($realization->image));

                    $image = $request->file('image');
                    $image->storeAs('realizations', $image->hashName(), 'public');

                    $data['image'] = $image->hashName();
                }

                $realization->update($data);
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
