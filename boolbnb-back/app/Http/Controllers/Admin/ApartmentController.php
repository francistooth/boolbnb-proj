<?php

namespace App\Http\Controllers\Admin;

use App\Functions\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApartmentRequest;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsor;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::orderBy('id', 'desc')->where('user_id', Auth::id())->get();
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

        $data['coordinate'] = Helper::generateCoordinate($data['address']);


        if (array_key_exists('img_path', $data)) {
            $path_image = Storage::put('uploads', $data['img_path']);
            $name_image = $request->file('img_path')->getClientOriginalName();
            $data['img_path'] = $path_image;
            $data['img_name'] = $name_image;
        }

        $new_apartment = Apartment::create($data);

        if (array_key_exists('services', $data)) {
            $new_apartment->services()->attach($data['services']);
        }



        return redirect(route('admin.apartments.show', $new_apartment));
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::id()) {
            abort(404);
        }

        $sponsors = Sponsor::all();

        return view('admin.apartments.show', compact('apartment', 'sponsors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        if ($apartment->user_id !== Auth::id()) {
            abort(404);
        }

        $services = Service::all();

        return view('admin.apartments.edit', compact('apartment', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApartmentRequest $request, Apartment $apartment)
    {
        $data = $request->all();

        if ($data['title'] != $apartment->title) {
            $data['slug'] = Helper::generateSlug($data['title'], Apartment::class);
        }

        $data['coordinate'] = Helper::generateCoordinate($data['address']);

        if (array_key_exists('img_path', $data)) {
            /* se carico un altra immagine al posto di quella vecchia devo cancellare la vecchia dallo storage */
            if ($apartment->path_image) {
                Storage::delete($apartment->path_image);
            }
            $path_image = Storage::put('uploads', $data['img_path']);
            $name_image = $request->file('img_path')->getClientOriginalName();
            $data['img_path'] = $path_image;
            $data['img_name'] = $name_image;
        }

        $apartment->update($data);

        if (array_key_exists('services', $data)) {
            $apartment->services()->sync($data['services']);
        } else {
            $apartment->services()->detach();
        }

        return redirect()->route('admin.apartments.show', compact('apartment'))->with('update', 'Il tuo appartamento è stato aggiornato');;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    { {
            $apartment->delete();
            return redirect()->route('admin.apartments.index')->with('delete', 'L\' appartamento in  ' . $apartment['address'] . ' è stato cancellato');
        }
    }
    public function trash()
    {
        $apartments = Apartment::onlyTrashed()->orderBy('id')->get();
        return view('admin.apartments.trash', compact('apartments'));
    }
    public function restore($id)
    {
        $apartment = Apartment::withTrashed()->find($id);
        $apartment->restore();
        return redirect()->route('admin.apartments.index')->with('message', 'l\' appartamento ' . $apartment->title . 'é stato ripristinto');
    }

    public function delete($id)
    {
        $apartment = Apartment::withTrashed()->find($id);
        if ($apartment->img_name) {
            Storage::delete($apartment->path_img);
        }
        $apartment->forceDelete();
        return redirect()->route('admin.apartments.index')->with('delete', 'L\' appartamento ' . $apartment->title . 'é stato eliminato definitivamente');
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
            ->get();

        return response()->json($apartments);
    }
}
