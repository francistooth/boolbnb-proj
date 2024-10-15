<?php

namespace App\Http\Controllers;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApartmentController extends Controller
{
    public function index()
    {
      $apartments = Apartment::all()->where('user_id', Auth::id());
      return view('admin.apartments.index', ['apartments' => $apartments]);
    }
}
