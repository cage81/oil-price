<?php

namespace App\Http\Controllers;

use App\Http\Resources\OilPriceResource;
use App\Models\OilPrice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class OilPriceController extends Controller
{
    public static function fillDatabaseFromUri() {

        $response = Http::get('https://datahub.io/core/oil-prices/r/brent-daily.json');
        $oilPrices = [];
        if ($response->ok()) {
            $oilPricesFromUri = $response->json();

            foreach ($oilPricesFromUri as $oilPrice) {
                $oilPrices[] = [
                    'iso_date' => $oilPrice['Date'],
                    'price' => $oilPrice['Price'],
                    'created_at' =>  Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            if (count($oilPrices) > 0) {
                OilPrice::query()->truncate();
                OilPrice::insert($oilPrices);
            }
        }

    }

    public function index(Request $request) {

        $params = $request->all();

        abort_if(empty($params),Response::HTTP_BAD_REQUEST, 'Missing parameters' );
        abort_if(empty($params['startDateISO8601']),Response::HTTP_BAD_REQUEST, 'Missing parameter \'startDateISO8601\'' );
        abort_if(empty($params['endDateISO8601']),Response::HTTP_BAD_REQUEST, 'Missing parameter \'endDateISO8601\'' );

        $oilPrices = OilPrice::whereBetween('iso_date', [$params['startDateISO8601'], $params['endDateISO8601']])->get();

        return OilPriceResource::collection($oilPrices);

    }
}
