<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public static function run()
    {
        $user= User::create([
            'name' => 'SuperAdmin',
            'email' => 'ionescu_nico@yahoo.com',
            'password' => Hash::make("Andra8787!"),
        ]);
        $user->assignRole('super');
    }
}
