<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class Roleseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Schema::enableForeignKeyConstraints();
        $data = [
            'manager', 'waiter', 'chef', 'cashier'
        ];
        foreach ($data as $value) {
            Role::insert([
                'name'=> $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
