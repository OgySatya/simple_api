<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();
        
            User::insert([
                'name'=> 'boss',
                'email'=> "boss@email.com",
                'password'=> Hash::make('123'),
                'role_id' => 1
            ]);
            User::insert([
                'name'=> 'waiter',
                'email'=> "waiter@email.com",
                'password'=> Hash::make('123'),
                'role_id' => 2
            ]);
            User::insert([
                'name'=> 'chef',
                'email'=> "chef@email.com",
                'password'=> Hash::make('123'),
                'role_id' => 3
            ]);
            User::insert([
                'name'=> 'cashier',
                'email'=> "cashier@email.com",
                'password'=> Hash::make('123'),
                'role_id' => 4
            ]);
        
    }
}
