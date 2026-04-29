<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Unit;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure Roles exist
        $roleSuper = Role::firstOrCreate(['name' => 'superadmin']);
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleStaff = Role::firstOrCreate(['name' => 'staff']);
        $roleUser = Role::firstOrCreate(['name' => 'user']);

        // 2. Ensure default Unit exists
        $unit = Unit::firstOrCreate(
            ['name' => 'Rektorat'],
            ['type' => 'rektorat', 'parent_id' => null]
        );

        // 3. Create Users

        // Super Admin
        $super = User::firstOrCreate(
            ['email' => 'superadmin@bmn.test'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password'),
                'unit_id' => $unit->id,
                'phone' => '081234567890',
                'is_active' => true,
                'approval_status' => 'approved',
            ]
        );
        $super->syncRoles($roleSuper);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@bmn.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'unit_id' => $unit->id,
                'phone' => '081234567891',
                'is_active' => true,
                'approval_status' => 'approved',
            ]
        );
        $admin->syncRoles($roleAdmin);

        // Staff
        $staff = User::firstOrCreate(
            ['email' => 'staff@bmn.test'],
            [
                'name' => 'Staff Operasional',
                'password' => Hash::make('password'),
                'unit_id' => $unit->id,
                'phone' => '081234567892',
                'is_active' => true,
                'approval_status' => 'approved',
            ]
        );
        $staff->syncRoles($roleStaff);

        // Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@bmn.test'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'unit_id' => $unit->id,
                'phone' => '081234567893',
                'is_active' => true,
                'approval_status' => 'approved',
            ]
        );
        $user->syncRoles($roleUser);
    }
}
