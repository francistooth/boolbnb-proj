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

            $sponsor = Sponsor::find($request->sponsor_id);
            $apartment = Apartment::find($request->apartment_id);

            //lista di sponsorizzazioni per appartamneto in ordine dal più recente
            $is_sponsored = ApartmentSponsor::where('apartment_id', $apartment->id)->orderBy('created_at', 'desc')->get();

            //se l'appartamento ha delle sponsor precedenti
            if (count($is_sponsored)) {
                //recupero l'ultimo ending_date disponibile
                $last_sponsor = $is_sponsored[0]->ending_date;

                //se l'ultima sponsor è maggiore della data di oggi (la sponsor è ancora in corso)
                if ($last_sponsor >= now()) {
                    //prendo last_sponsor
                    $date = new DateTime($last_sponsor);
                    //aggiungo la durata della sponsor selezionata
                    $date->add(new DateInterval('PT' . $sponsor->duration . 'H'));
                    // dd($last_sponsor . ' + ' . $sponsor->duration .  ' = ' . $date->format('Y-m-d H:i:s'));
                } else {
                    //se la sponsor è scaduta prendo la data di oggi e aggiungo la durata della sponsor selezionata
                    $date = now()->addHours($sponsor->duration);
                }
            } else {
                //se non ho delle sponsor precedenti
                $date = now()->addHours($sponsor->duration);
            }

            $apartment->sponsors()->attach($sponsor, ["ending_date" => $date]);

            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('sponsor_success', 'Pagamento effettuato con successo! L\'appartamento sarà sponsorizzato fino al ' . $date->format('d/m/Y \o\r\e H:i'));
        } else {
            return redirect()->route('admin.apartments.show', $request->apartment_id)->with('error', 'Pagamento fallito!');
        }
    }
}
