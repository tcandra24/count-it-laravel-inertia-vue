<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'dashboard.index', 'guard_name' => 'web']);

        Permission::create(['name' => 'master.plans.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.plans.show', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.plans.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.plans.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.plans.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'master.income.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.income.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.income.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'master.income.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'transaction.realizations.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.realizations.show', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.realizations.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.realizations.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'transaction.realizations.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'setting.users.index', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.create', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.edit', 'guard_name' => 'web']);
        Permission::create(['name' => 'setting.users.destroy', 'guard_name' => 'web']);

        Permission::create(['name' => 'report.outcome.destroy', 'guard_name' => 'web']);
    }
}
