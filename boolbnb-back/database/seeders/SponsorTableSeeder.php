<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sponsor;

class SponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sponsors = config('sponsors');
        foreach ($sponsors as $sponsor) {
            $new_sponsor = new Sponsor();
            $new_sponsor->title = $sponsor['title'];
            $new_sponsor->price = $sponsor['price'];
            $new_sponsor->duration = $sponsor['duration'];
            $new_sponsor->save();
        }
    }
}
