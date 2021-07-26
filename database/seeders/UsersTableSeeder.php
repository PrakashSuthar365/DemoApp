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
        $userData = [
            [
               'name'=>'admin',
               'email'=>'a@admin.com',
               'role_id'=>'1',
               'password'=> Hash::make('123456'),
            ],
            [
               'name'=>'user',
               'email'=>'b@user.com',
               'role_id'=>'2',
               'password'=> Hash::make('123456'),
            ],
            [
               'name'=>'guest',
               'email'=>'c@user.com',
                'role_id'=>'2',
               'password'=> Hash::make('123456'),
            ],
        ];
  
        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
