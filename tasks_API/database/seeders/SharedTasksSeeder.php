<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SharedTask;

class SharedTasksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SharedTask::truncate();
    }
}
