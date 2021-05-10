<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Http\Resources\OilPriceResource;
use App\Models\OilPrice;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use phpDocumentor\Reflection\Types\Collection;
use Sajya\Server\Procedure;
use Illuminate\Support\Facades\Log;

class OilPriceProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'GetOilPriceTrend';

    /**
     * Execute the procedure.
     *
     * @param Request $request
     *
     * @return array|string|integer
     */
    public function GetOilPriceTrend(Request $request)
    {
        $params = $request->all();

        Log::debug('GetOilPriceTrend handle ' . json_encode($params));

        abort_if(empty($params),Response::HTTP_BAD_REQUEST, 'Missing parameters' );
        abort_if(empty($params['startDateISO8601']),Response::HTTP_BAD_REQUEST, 'Missing parameter \'startDateISO8601\'' );
        abort_if(empty($params['endDateISO8601']),Response::HTTP_BAD_REQUEST, 'Missing parameter \'endDateISO8601\'' );

        $oilPrices = OilPrice::whereBetween('iso_date', [$params['startDateISO8601'], $params['endDateISO8601']])->get(['iso_date AS dateISO8601', 'price']);

        return OilPriceResource::collection(["prices" => $oilPrices]);
    }

    /**
     * Execute the procedure.
     *
     * @return string
     *
    public function ping()
    {
        return 'pong';
    }
    */
}
