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
        $userData = [];
        for ($i = 0; $i < 100; ++$i) {
            $type = rand(1,2);
            $userType = ($type == 1) ? 'admin':'user';
            $arr = [
                'name'=>$userType.$i,
                'email'=>$userType.$i.'@admin.com',
                'role_id'=>$type,
                'password'=> Hash::make('123456'),
            ];
            $userData[] = $arr;
        }
  
        foreach ($userData as $key => $val) {
            User::create($val);
        }
    }
}
