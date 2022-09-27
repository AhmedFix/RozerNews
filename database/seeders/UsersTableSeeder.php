<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'super_admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('123321'),
            'type' => 'super_admin',
            'profile_picture'=> 'avatar.png'
        ]);

        $user->attachRole('super_admin');

    }//end of run

}//end of seeder
