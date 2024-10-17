<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;


class PageController extends Controller
{
    public function allApartments()
    {
        $apartments = Apartment::orderBy('id')->with('services', 'sponsors')->paginate(10);
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

    public function service(){
         $service=Service::all();
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
}