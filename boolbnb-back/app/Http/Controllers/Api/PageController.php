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
        // Puoi eventualmente prendere lat, lon e radius da $request se necessario
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $radius = $request->input('radius');

        $apartments = DB::table('apartments')
            ->selectRaw('*, (6371 * ACOS(
                COS(RADIANS(?)) *
                COS(RADIANS(SUBSTRING_INDEX(coordinate, \',\', -1))) *
                COS(RADIANS(SUBSTRING_INDEX(coordinate, \',\', 1)) - RADIANS(?)) +
                SIN(RADIANS(?)) *
                SIN(RADIANS(SUBSTRING_INDEX(coordinate, \',\', -1)))
            )) AS distance', [$lat, $lon, $lat])
            ->having('distance', '<=', $radius)
            ->orderBy('distance')
            ->get();

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
    /* public function getApartmentsInRange(Request $request)
    {
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $radius = $request->input('radius') * 1000; // Converti i km in metri

        $apartments = DB::table('apartments')
            ->select('*', DB::raw(
                "(6371 * ACOS(
                    COS(RADIANS($lat)) *
                    COS(RADIANS(SUBSTRING_INDEX(coordinate, ',', -1))) *
                    COS(RADIANS(SUBSTRING_INDEX(coordinate, ',', 1)) - RADIANS($lon)) +
                    SIN(RADIANS($lat)) *
                    SIN(RADIANS(SUBSTRING_INDEX(coordinate, ',', -1)))
                )) AS distance"
            ))
            ->having('distance', '<=', $radius)
            ->get();

        return response()->json($apartments);

    } */
    /* public function getApartmentsInRange(Request $request)
    {
        $lat = $request->input('lat');
        $lon = $request->input('lon');
        $radius = $request->input('radius') * 1000; // Converti i km in metri

        $apartments = DB::table('apartments')
            ->select('*', DB::raw(
                "(6371 * acos(cos(radians($lat))
                * cos(radians(latitude))
                * cos(radians(longitude) - radians($lon))
                + sin(radians($lat))
                * sin(radians(latitude)))) AS distance"
            ))
            ->having('distance', '<=', $radius)
            ->get();

        return response()->json($apartments);

    } */
}
