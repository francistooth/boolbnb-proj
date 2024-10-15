<?php

namespace App\Functions;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

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
        $coordinate_long_lat = json_decode($data_coordinate);

        if (!empty($coordinate_long_lat->results[0])) {
            $lon = $coordinate_long_lat->results[0]->position->lon;
            $lat = $coordinate_long_lat->results[0]->position->lat;
            // Imposta coordinate_long_lat usando ST_PointFromText
            return $coordinate_long_lat = DB::raw("ST_PointFromText('POINT($lon $lat)')");
        }
        /*
        query per decodificare i dati nel db
        DB::raw('ST_AsText(coordinate_long_lat) as coordinate_long_lat'))->get();
        */
    }
}
