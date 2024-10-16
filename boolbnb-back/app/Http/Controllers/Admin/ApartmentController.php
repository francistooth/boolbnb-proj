<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all()->where('user_id', Auth::id());
        return view('admin.apartments.index', ['apartments' => $apartments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();

        return view('admin.apartments.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApartmentRequest $request)
    {
        $data = $request->all();

        $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);

        $data['user_id'] = Auth::id();

        $data['coordinate_long_lat'] = Helper::generateCoordinate($data['address']);

        $new_apartment = Apartment::create($data);

        if (array_key_exists('services', $data)) {
            $new_apartment->services()->attach($data['services']);
        }

        dd($new_apartment);

        return redirect(route('admin.apartments.show', $new_apartment));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $apartments = Apartment::find($id);

        if($apartments->user_id !== Auth::id()){
          abort(404);
      }

        return view('admin.apartments.show', compact('apartments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
