<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\StorePermissionRequest;
use App\Http\Requests\Settings\UpdatePermissionRequest;
use Inertia\Inertia;

// Models
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();

        return Inertia::render('settings/permissions/Index', ['permissions' => $permissions]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('settings/permissions/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        try {
            Permission::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);

           return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {
         return Inertia::render('settings/permissions/Edit', ['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        try {
            $permission->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name
            ]);

           return redirect()->route('permissions.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            Permission::where('id', $id)->delete();
        } catch (\Exception $e) {
            return back();
        }
    }
}
