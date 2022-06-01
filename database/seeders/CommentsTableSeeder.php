<?php

namespace Database\Seeders;

use App\Models\Offer;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comment = new \App\Models\Comment;
        $comment->title = "Hab leider keine Zeit";
        $comment->commenttext = "Könnten wir den Appointment auf 15.3.22 verschieben?";

        $offer = Offer::all()->first();
        $comment->offer()->associate($offer);

        $user = User::all()->first();
        $comment->user()->associate($user);
        $comment->save();


    }
}
