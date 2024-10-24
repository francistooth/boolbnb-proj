<?php

namespace App\Functions;

use Illuminate\Support\Str;
use Braintree\Gateway;

class Helper
{

    public static function generateSlug($string, $model)
    {

        $slug = Str::slug($string, '-');
        $original_slug = $slug;

        $exists = $model::where('slug', $slug)->first();

        $c = 1;

        while ($exists) {
            $slug = $original_slug . '-' . $c;
            $exists = $model::where('slug', $slug)->first();
            $c++;
        }

        return $slug;
    }

    public static function generateCoordinate($string)
    {
        $encoded_address = urlencode($string);
        $data_coordinate = file_get_contents('https://api.tomtom.com/search/2/geocode/' . $encoded_address . '.json?key=PmDZl7vx3YsaUvAjiu8WRKIDvd4SGoNG');
        $coordinate = json_decode($data_coordinate);

        if (!empty($coordinate->results[0])) {
            $lon = $coordinate->results[0]->position->lon;
            $lat = $coordinate->results[0]->position->lat;

            return $coordinate = $lon . ', ' . $lat;
        }
    }

    public static function getGateway()
    {
        return new Gateway([
            'environment' => config('services.braintree.environment'),
            'merchantId' => config('services.braintree.merchantId'),
            'publicKey' => config('services.braintree.publicKey'),
            'privateKey' => config('services.braintree.privateKey'),
        ]);
    }
}
