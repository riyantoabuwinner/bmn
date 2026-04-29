<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Initial Users, Roles & Units
        $this->call(UserSeeder::class);

        // 2. Import BMN Assets (V2)
        $seederPath = __DIR__ . '/BmnImportSeederV2.php';
        if (file_exists($seederPath)) {
            require_once $seederPath;
            $seeder = new BmnImportSeederV2();
            if (isset($this->command)) {
                $seeder->command = $this->command;
            }
            $seeder->run();
        }
    }
}
