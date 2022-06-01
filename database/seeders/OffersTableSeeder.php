<?php

namespace Database\Seeders;

use App\Models\User;
use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offer = new \App\Models\Offer;
        $offer->title = "JAVA";
        $offer->description = "Java Nachhilfe jetzt sichern";
        $offer->subject = "Java Programmieren";

        $user = User::all()->first();
        $offer->user()->associate($user);
        $offer->save();

//        DB::table('offers')->insert([
//            'title'=>Str::random(100),
//            'description'=>Str::random(1000),
//            'subject'=>Str::random(25),
//
//            'created_at'=>date("Y-m-d H:i:s"),
//            'updated_at'=>date("Y-m-d H:i:s")
//        ]);
    }
}
