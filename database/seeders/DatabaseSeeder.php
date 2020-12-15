<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name'=>'Admin',
            'email'=> 'admin@gmail.com',
            'password'=>bcrypt('123456'),
            'contact'=>'1234567890',
            'address'=> 'Admin Address',
            'gender'=>'Male',
            'date_of_birth'=>'11-11-1999',
            'role'=>'admin',
            'image'=>'abc.png',

        ]);
        // User::create([
        //     'name'=>'Poonam',
        //     'email'=> 'o7services020@gmail.com',
        //     'password'=>bcrypt('Poonam@123'),
        //     'contact'=>'7814417338',
        //     'address'=> 'Jalandhar',
        //     'gender'=>'Female',
        //     'date_of_birth'=>'11-11-1999',
        //     'role'=>'admin',
        //     'image'=>'abc.png',

        // ]);
    }
}
