<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Modul;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Customer::factory(1000)->create();

        \App\Models\User::factory()->create([
            'name' => 'Developer',
            'username' => 'developer',
            'email' => 'developer@gmail.com',
            'password' => bcrypt('developer'),
        ]);

        // Role::factory()->create([
        //     'name' => 'developer',
        //     'guard_name' => 'web'
        // ]);

        // Permission::factory()->create([
        //     // USER ACCOUNT
        //     [
        //         'name' => 'user_account view',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'user_account detail',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'user_account create',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'user_account edit',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'user_account delete',
        //         'guard_name' => 'web'
        //     ],

        //     // MODUL
        //     [
        //         'name' => 'modul view',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'modul detail',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'modul create',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'modul edit',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'modul delete',
        //         'guard_name' => 'web'
        //     ],

        //     // GROUP ACCESS
        //     [
        //         'name' => 'group_access view',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'group_access detail',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'group_access create',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'group_access edit',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'group_access delete',
        //         'guard_name' => 'web'
        //     ],

        //     // LOG ACTIVITY
        //     [
        //         'name' => 'log_activity view',
        //         'guard_name' => 'web'
        //     ],
        //     [
        //         'name' => 'log_activity detail',
        //         'guard_name' => 'web'
        //     ],
        // ]);

    }
}
