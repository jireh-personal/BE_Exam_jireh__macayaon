<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Jireh Macayaon',
            'username' => 'jireh',
            'role' => 'admin',
            'email' => 'jirehmacayaon.msc@gmail.com',
            'password' => Hash::make('admin12345'),
        ]);
        User::create([
            'name' => 'I am admin',
            'username' => 'admin@gmail.com',
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin54321'),
        ]);
    }
}
