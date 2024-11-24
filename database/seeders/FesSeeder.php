<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fes;
use App\Models\User;

class FesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fes = Fes::find(1);
        $user = User::find(2);
        $fes->user()->associate($user);
        $fes->save();
    }
}
