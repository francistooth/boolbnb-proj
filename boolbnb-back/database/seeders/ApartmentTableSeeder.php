<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Functions\Helper;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ApartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $apartments = config('apartments');
        foreach ($apartments as $apartment) {
            $new_apartment = new Apartment();
            $new_apartment->title = $apartment['title'];
            $new_apartment->slug = Helper::generateSlug($new_apartment->title, Apartment::class);
            $new_apartment->user_id = rand(1, 7);
            $new_apartment->description = $apartment['description'];
            $new_apartment->room = rand(1, 6);
            $new_apartment->bed = $new_apartment->room * 2;
            $new_apartment->bathroom = rand(1, 3);
            $new_apartment->sqm = (($new_apartment->room * 20) + ($new_apartment->bathroom * 10));
            $new_apartment->address = $apartment['address'];
            $new_apartment->coordinate = Helper::generateCoordinate($new_apartment->address);
            // $new_apartment->img_path = "/img/apartment" . rand(1, 16) . ".jpg";


            $new_apartment->img_path = 'uploads/apartment' . rand(1, 16) . '.jpg';

            $new_apartment->img_name = $new_apartment->img_path;
            $new_apartment->is_visible = true;
            $new_apartment->save();
        }
    }
}
