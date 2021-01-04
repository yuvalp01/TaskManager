<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        // $faker = \Faker\Factory::create();
        $password = Hash::make('1234');

        User::truncate();
        User::create([//1
            'name' => 'אילן מאסק',
            'email' => 'elon@mask.com',
            'password' => $password
        ]);
        User::create([//2
            'name' => 'ביל גייטס',
            'email' => 'bill@gates.com',
            'password' => $password
        ]);
        User::create([//3
            'name' => 'דונלד טראמפ',
            'email' => 'donald@trump.com',
            'password' => $password
        ]);
        User::create([//4
            'name' => 'מוחמד עלי',
            'email' => 'mohamad@ali.com',
            'password' => $password
        ]);
    }
}
