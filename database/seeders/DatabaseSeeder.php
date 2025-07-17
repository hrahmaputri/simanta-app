<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        /* User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/

        /*User::create([
            'name' => 'Tim SIMETA',
            'email' => 'simeta_bkpsdm',
            'email_verified_at' => now(),
            'password' => Hash::make('smt1234'),
            'password_2' => 'smt1234',
            'remember_token' => Str::random(10),
        ]);

        User::create([
            'name' => 'Administrator',
            'email' => 'simetaadmin',
            'email_verified_at' => now(),
            'password' => Hash::make('simetaadmin1234'),
            'password_2' => 'simetaadmin1234',
            'remember_token' => Str::random(10),
        ]);*/

        User::create([
            'name' => 'Kaban BKPSDM',
            'email' => 'kaban_bkpsdm',
            'email_verified_at' => now(),
            'password' => Hash::make('kaban4321'),
            'password_2' => 'kaban4321',
            'remember_token' => Str::random(10),
            'id_akses' => 2,
        ]);
    }
}
