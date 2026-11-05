<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Dima',
            'email' => 'admin5682017@gmail.com',
            'password' => bcrypt('password')
       ]);
    }
}
