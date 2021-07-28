<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'MegaFundas',
            'address' => 'Zona Villa Corina',
            'phone' => 69658908
        ]);

        $admin = User::create([
            'name' => 'Augusto Carvalho',
            'phone' => 69658908,
            'profile' => 'ADMIN',
            'status' => 'ACTIVE',
            'email' => 'auguss24@gmail.com',
            'password' => Hash::make('password')
        ]);
        
        $admin->assignRole('Admin');

        $manager = User::create([
            'name' => 'Erick Fernando',
            'phone' => 76885027,
            'profile' => 'EMPLOYEE',
            'status' => 'ACTIVE',
            'email' => 'erick@gmail.com',
            'password' => Hash::make('password')
        ]);

        $manager->assignRole('Manager');
    }
}
