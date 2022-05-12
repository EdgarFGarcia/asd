<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AccessLevel;

class AccessLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        AccessLevel::create([
            'name' => 'free'
        ]);

        AccessLevel::create([
            'name' => 'paid'
        ]);
    }
}
