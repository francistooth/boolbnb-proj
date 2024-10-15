<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class ServiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            "Colazione",
            "Wi-Fi",
            "Piscina",
            "Pulizia giornaliera",
            "Servizio di accoglienza",
            "Informazioni turistiche",
            "Parcheggio",
            "Terrazza",
            "Giardino",
            "Servizio di trasporto",
            "Cucina",
            "Animali ammessi"
        ];

        foreach ($services as $service) {
            $new_service = new Service;
            $new_service->name = $service;
            $new_service->save();
        }
    }
}
