<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsor;
use Braintree\Gateway;
use Carbon\Carbon;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    private $gateway;

    public function __construct()
    {
        $this->gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]);
    }

    public function create(Request $request)
    {
        $clientToken = $this->gateway->clientToken()->generate();

        // Passa il token alla view per il form di pagamento
        return view('admin.apartments.show', [
            'clientToken' => $clientToken,
            'apartment' => Apartment::find($request->apartment_id),
            'sponsor' => Sponsor::find($request->sponsor_id),
        ]);
    }

    public function store(Request $request)
    {
        // Effettua la transazione
        $result = $this->gateway->transaction()->sale([
            'amount' => $request->amount, // Dovrai impostare l'importo corretto dinamicamente
            'paymentMethodNonce' => $request->payment_method_nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {
            // Se la transazione ha successo, crea la relazione sponsor-apartment
            $sponsor = Sponsor::find($request->sponsor_id);
            $ending_date = now()->addHours($sponsor->duration);

            Apartment::find($request->apartment_id)->sponsors()->attach($sponsor->id, [
                'ending_date' => $ending_date,
                'created_at' => now(),
            ]);

            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('sponsor_success', 'Pagamento effettuato con successo! L\'appartamento sarà sponsorizzato fino al ' . $ending_date->format('d/m/Y \o\r\e H:i'));
        } else {
            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('error', 'Pagamento fallito!');
        }
    }
}
