<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

// Models
use App\Models\Unit;

// Requests
use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::all();

        return Inertia::render('master/units/Index', ['units' => $units]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('master/units/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        try {
            Unit::create([
                'name' => $request->name
            ]);

            return redirect()->route('units.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return Inertia::render('master/units/Edit', ['unit' => $unit]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        try {
            $unit->update([
                'name' => $request->name
            ]);

           return redirect()->route('units.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        try {
            $unit->delete();
        } catch (\Exception $e) {
            return back();
        }
    }
}
