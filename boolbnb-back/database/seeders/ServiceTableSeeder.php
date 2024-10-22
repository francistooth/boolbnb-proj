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
        $icon = [
            'fa-solid fa-coffee',
            'fa-solid fa-wifi',
            'fa-solid fa-water',
            'fa-solid fa-broom',
            'fa-solid fa-concierge-bell',
            'fa-solid fa-info-circle',
            'fa-solid fa-parking',
            'fa-brands fa-wirsindhandwerk',
            'fa-solid fa-tree',
            'fa-solid fa-bus',
            'fa-solid fa-utensils',
            'fa-solid fa-paw'
        ];

        foreach ($services as $index => $service) {
            $new_service = new Service;
            $new_service->name = $service;
            $new_service->icon = $icon[$index];
            $new_service->save();
        }
    }
}
