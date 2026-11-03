<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'poadmin@gmail.com'],
            [
                'name' => 'PO Admin',
                'password' => 'admin123',
            ]
        );

        User::factory(5)->create();
    }
}
