<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;


class ResetReportCountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::query()->update(['report_count' => 0]);
        User::query()->update(['status' => 'active']);

    }
}
