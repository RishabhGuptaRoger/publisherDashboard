<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Check if user exists
        $user = User::where('email', 'rayblaze12@gmail.com')->first();

        // If user doesn't exist, create them and set as admin
        if (!$user) {
            User::create([
                'name' => 'Rishabh',
                'email' => 'rayblaze12@gmail.com',
                'password' => bcrypt('digifish'),
                'is_admin' => true,
            ]);
        } else {
            // If user exists, ensure they're set as admin
            $user->update(['is_admin' => true]);
        }
    }
}
