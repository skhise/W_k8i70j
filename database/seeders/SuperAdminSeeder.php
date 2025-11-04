<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if user already exists
        $existingUser = User::where('email', 'super@admin.com')->first();
        
        if ($existingUser) {
            $this->command->info('Super admin user already exists!');
            return;
        }

        // Create super admin user
        User::create([
            'name' => 'Super Admin',
            'email' => 'super@admin.com',
            'password' => Hash::make('123456'),
            'role' => 0, // Super Admin role
            'isOnline' => 0,
        ]);

        $this->command->info('Super admin user created successfully!');
        $this->command->info('Email: super@admin.com');
        $this->command->info('Password: 123456');
    }
}

