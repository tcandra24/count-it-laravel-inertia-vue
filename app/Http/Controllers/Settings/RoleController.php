<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

// Requests
use App\Http\Requests\Settings\StoreRoleRequest;
use App\Http\Requests\Settings\UpdateRoleRequest;

// Models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::with(['permissions'])->get();

        return Inertia::render('settings/roles/Index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();

        return Inertia::render('settings/roles/Create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        try {
            $role = Role::create([
                'name' => $request->name,
            ]);

            $permissions = collect($request->permissions)->pluck('id')->toArray();
            $role->givePermissionTo($permissions);

           return redirect()->route('roles.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load(['permissions']);

        return Inertia::render('settings/roles/Edit', ['role' => $role,'permissions' => $permissions]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        try {
            $role->update([
                'name' => $request->name,
            ]);

            $permissions = collect($request->permissions)->pluck('id')->toArray();
            $role->syncPermissions($permissions);

           return redirect()->route('roles.index');
        } catch (\Exception $e) {
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Role::where('id', $id)->delete();
        } catch (\Exception $e) {
            return back();
        }
    }
}
