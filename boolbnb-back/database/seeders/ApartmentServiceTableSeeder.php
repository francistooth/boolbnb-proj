<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Apartment;
use App\Models\Service;

class ApartmentServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            $apartment = Apartment::inRandomOrder()->first();
            $service_id = Service::inRandomOrder()->first()->id;
            if (!$apartment->services()->where('service_id', $service_id)->exists()) {
                $apartment->services()->attach($service_id);
            }
        }
    }
}
