<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('NAILS_ADMIN_EMAIL', 'admin@nails.local');
        $password = env('NAILS_ADMIN_PASSWORD', 'ChangeThisPassword123!');

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Jessica Admin',
                'password' => $password,
            ],
        );
    }
}
