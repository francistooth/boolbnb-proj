<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Support\Carbon;
use Illuminate\Support\Testing\Fakes\Fake;



class ApartmentSponsorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $duration = [1, 3, 7];
        for ($i = 0; $i < 10; $i++) {
            $apartment = Apartment::inRandomOrder()->first();
            $sponsor = Sponsor::inRandomOrder()->first()->id;
            $create_at = Carbon::now();
            // Definisci il numero di giorni basato sullo sponsor_id
            switch ($sponsor) {
                case 1:
                    $daysToAdd = 1;
                    break;
                case 2:
                    $daysToAdd = 3;
                    break;
                case 3:
                    $daysToAdd = 7;
                    break;
                default:
                    $daysToAdd = 0; // Caso di fallback, nel caso ci siano altri sponsor
                    break;
            }
            $ending_date = $create_at->clone()->addDay($daysToAdd);
            $apartment->sponsors()->attach($sponsor, [
                'created_at' => $create_at,
                'ending_date' => $ending_date
            ]);
        }
    }
}
