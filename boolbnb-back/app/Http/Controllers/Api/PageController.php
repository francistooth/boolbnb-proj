<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class PageController extends Controller
{
    public function allApartments()
    {
        $apartments = Apartment::orderBy('id')->with('services', 'sponsors')->get();
        if ($apartments) {
            $success = true;
            foreach ($apartments as $apartment) {
                if ($apartment->img_path) {
                    $apartment->img_path = Storage::url($apartment->img_path);
                } else {
                    $apartment->img_path = Storage::url('default-image.jpg');
                    $apartment->img_name = 'No-img';
                }
            }
        } else {
            $success = false;
        }
        return response()->json(compact('success', 'apartments'));
    }

    public function apartment($slug)
    {

        $apartment = Apartment::where('slug', $slug)->with('services', 'sponsors')->first();
        if ($apartment) {
            $success = true;
            if ($apartment->img_path) {
                $apartment->img_path = Storage::url($apartment->img_path);
            } else {
                $apartment->img_path = Storage::url('default-image.jpg');
                $apartment->img_name = 'No-img';
            }
        } else {
            $success = false;
        }
        return response()->json(compact('success', 'apartment'));
    }

    public function service()
    {
        $service = Service::all();
        if ($service) {
            $success = true;
        } else {
            $success = false;
        }
        $data = [
            'success' => $success,
            'result' => $service
        ];
        return response()->json($data);
    }
    public function getApartmentsInRange(Request $request)
    {
        // Recupera lat, lon e radius dal request
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $radius = $request->input('radius');
        $rooms = $request->input('rooms');
        $beds = $request->input('beds');
        $services = $request->input('services');

        $apartments = DB::table('apartments')
            ->selectRaw('apartments.*, (6371 * ACOS(
            COS(RADIANS(?)) *
            COS(RADIANS(SUBSTRING_INDEX(coordinate, \',\', -1))) *
            COS(RADIANS(SUBSTRING_INDEX(coordinate, \',\', 1)) - RADIANS(?)) +
            SIN(RADIANS(?)) *
            SIN(RADIANS(SUBSTRING_INDEX(coordinate, \',\', -1)))
        )) AS distance', [$lat, $lon, $lat])
            ->having('distance', '<=', $radius);

        if ($rooms) {
            $apartments->where('room', '>=', $rooms);
        }
        if ($beds) {
            $apartments->where('bed', '>=', $beds);
        }

        if ($services) {
            $servicesArray = is_array($services) ? $services : explode(',', $services);
            $servicesId = Service::whereIn('name', $servicesArray)->pluck('id')->toArray();

            // Usa join per filtrare per servizi
            $apartments->join('apartment_service', 'apartments.id', '=', 'apartment_service.apartment_id')
                ->whereIn('apartment_service.service_id', $servicesId)
                ->groupBy('apartments.id')
                ->havingRaw('COUNT(apartment_service.service_id) = ?', [count($servicesId)]); // Assicura che ci siano tutti i servizi
        }

        $apartments = $apartments->orderBy('distance')->get();

        // Aggiungi le immagini
        foreach ($apartments as $apartment) {
            if ($apartment->img_path) {
                $apartment->img_path = Storage::url($apartment->img_path);
            } else {
                $apartment->img_path = Storage::url('default-image.jpg');
                $apartment->img_name = 'No-img';
            }
        }

        return response()->json($apartments);
    }
}
