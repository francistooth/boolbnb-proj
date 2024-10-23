<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\ApartmentSponsor;
use App\Models\Sponsor;
use Braintree\Gateway;
use Carbon\Carbon;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;



class PaymentController extends Controller
{
    private $gateway;

    public function store(Request $request)
    {
        $this->gateway = new \Braintree\Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]);

        // Effettua la transazione
        $result = $this->gateway->transaction()->sale([
            'amount' => $request->amount,
            'paymentMethodNonce' => $request->payment_method_nonce,
            'options' => [
                'submitForSettlement' => True
            ]
        ]);

        if ($result->success) {

            $sponsor = Sponsor::find($request->sponsor_id);
            $apartment = Apartment::find($request->apartment_id);

            //prendo l'ultima sponsorizzaione disponibile dell'appartamento selezionato
            $last_sponsor = ApartmentSponsor::where('apartment_id', $apartment->id)
                ->orderBy('ending_date', 'desc')
                ->first();

            // se esiste una sponsorizzazione && l'ending date dell'ultima sponsorizzazione è maggiore uguale ad adesso
            if ($last_sponsor && $last_sponsor->ending_date >= now()) {
                // aggiungi la durata della sponsor selezionata alla sponsorizzazione in corso
                $date = new DateTime($last_sponsor->ending_date);
                $date->add(new DateInterval('PT' . $sponsor->duration . 'H'));
            } else {
                // se la sponsorizzazione è scaduta, oppure non è mai esistita: inizia la nuova sponsorizzazione da ora
                $date = now()->addHours($sponsor->duration);
            }

            // elimina le sponsorizzazioni precedenti per quell'appartamento
            // $apartment->sponsors()->detach();

            // crea la relazione sponsor apartment con la nuova data di fine
            $apartment->sponsors()->attach($sponsor->id, ['ending_date' => $date]);

            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('sponsor_success', 'Pagamento effettuato con successo! L\'appartamento sarà sponsorizzato fino al ' . $date->format('d/m/Y \o\r\e H:i'));
        } else {
            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('error', 'Pagamento fallito!');
        }
    }
}
