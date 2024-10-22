<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sponsor_id' => 'required|exists:sponsors,id',
            'apartment_id' => 'required|exists:apartments,id',
        ]);

        $sponsor = Sponsor::find($request->sponsor_id);

        $ending_date = now()->addHours($sponsor->duration);

        // dd($ending_date);

        Apartment::find($request->apartment_id)->sponsors()->attach($sponsor->id, [
            'ending_date' => $ending_date,
            'created_at' => now(),
        ]);
    }
}
