<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@peims.test')],
            [
                'name' => env('ADMIN_NAME', 'PEIMS Administrator'),
                'username' => env('ADMIN_USERNAME', 'admin'),
                'password' => env('ADMIN_PASSWORD', 'ChangeMeNow!2026'),
            ]
        );
    }
}
