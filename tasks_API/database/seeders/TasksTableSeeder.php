<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Task;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {
        Task::truncate();
        Task::create([
            'title' => 'משימה 1',
            'user_id' => 1,
            'is_done' => 1
        ]);

        Task::create([
            'title' => 'משימה 2',
            'user_id' => 1,
            'is_done' => 0
        ]);
        Task::create([
            'title' => 'משימה 3',
            'user_id' => 1,
            'is_done' => 0
        ]);
        Task::create([
            'title' => 'משימה 4',
            'user_id' => 1,
            'is_done' => 0
        ]);
        Task::create([
            'title' => 'משימה 5',
            'user_id' => 1,
            'is_done' => 0
        ]);
        Task::create([
            'title' => 'משימה 6',
            'user_id' => 1,
            'is_done' => 1
        ]);
        Task::create([
            'title' => 'משימה 7',
            'user_id' => 1,
            'is_done' => 1
        ]);
        Task::create([
            'title' => 'משימה 8',
            'user_id' => 2,
            'is_done' => 0
        ]);
        Task::create([
            'title' => 'משימה 9',
            'user_id' => 2,
            'is_done' => 1
        ]);
        Task::create([
            'title' => 'משימה 10',
            'user_id' => 3,
            'is_done' => 1
        ]);
    }
}