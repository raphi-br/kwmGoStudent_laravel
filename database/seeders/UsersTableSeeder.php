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
        $user = new User();
        $user->name ="Lehrer";
        $user->email="lehrer@gmail.com";
        $user->password = bcrypt('secret');
        $user->telnumber = "+43680/1526679";
        $user->role = 1;
        $user->save();

        $user2 = new User();
        $user2->name ="Schüler";
        $user2->email="schueler@gmail.com";
        $user2->password = bcrypt('secret');
        $user2->telnumber = "+43680/1526679";
        $user2->role = 0;
        $user2->save();
    }
}
