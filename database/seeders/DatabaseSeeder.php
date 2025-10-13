<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Əsas demo istifadəçi (optional)
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Digər seederləri işə salırıq
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
