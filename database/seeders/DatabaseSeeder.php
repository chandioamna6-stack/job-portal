<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Run RoleSeeder (so roles exist)
        $this->call(RoleSeeder::class);

        // 2. Create default admin user if not exists
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'], // unique identifier
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // change password later
                'role' => 'admin',
            ]
        );

        // 3. Assign "admin" role via Spatie
        $admin->assignRole('admin');

        // (Optional) Create a test employer
        $employer = User::firstOrCreate(
            ['email' => 'employer@gmail.com'],
            [
                'name' => 'Employer User',
                'password' => bcrypt('password'),
                'role' => 'employer',
            ]
        );
        $employer->assignRole('employer');

        // (Optional) Create a test job seeker
        $jobSeeker = User::firstOrCreate(
            ['email' => 'jobseeker@gmail.com'],
            [
                'name' => 'Job Seeker User',
                'password' => bcrypt('password'),
                'role' => 'job_seeker',
            ]
        );
        $jobSeeker->assignRole('job_seeker');
    }
}
