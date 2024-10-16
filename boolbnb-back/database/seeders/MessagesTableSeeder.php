<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Message;
use Faker\Generator as Faker;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Faker $faker): void
    {
        $numberOfMessages = 30;

        for ($i = 0; $i < $numberOfMessages; $i++) {
            $new_message = new Message();
            $new_message->apartment_id = $faker->numberBetween(0, 30);
            $new_message->name = $faker->name();
            $new_message->email = $faker->safeEmail();
            $new_message->message = $faker->sentence();
            $new_message->save();
        }
    }
}
