<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Card;
use App\FinancialEntity;
use App\FinancialInstrument;
use App\FinancialInstrumentType;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class FinancialInstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(FinancialInstrument::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $identifier = $request->get('identifier', '');
        $alias = $request->get('alias', '');
        $balance = $request->get('balance', 0);
        $accountId = $request->get('account_id', null);
        $financialEntityId = $request->get('financial_entity_id', null);
        $financialInstrumentTypeId = $request->get('financial_instrument_type_id', null);

        // Card Data

        $provider = $request->get('provider', null);
        $cardIdentifier = $request->get('card_identifier', null);

        $response = [
            'ok' => 1
        ];

        try {
            $account = Account::findOrFail($accountId);
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
            return response()
                ->json($response);
        }

        $financialEntity = FinancialEntity::find($financialEntityId);
        $financialInstrumentType = FinancialInstrumentType::find($financialInstrumentTypeId);

        $financialInstrument = new FinancialInstrument;
        $financialInstrument->identifier = $identifier;
        $financialInstrument->alias = $alias;
        $financialInstrument->balance = $balance;
        $financialInstrument->account()
            ->associate($account);

        if ($financialEntity != null)
            $financialInstrument->financialEntity()
                ->associate($financialEntity);

        $financialInstrument->type()
            ->associate($financialInstrumentType);
        $financialInstrument->save();

        if (!empty($provider) && !empty($cardIdentifier)){
            $card = new Card;
            $card->provider = $provider;
            $card->identifier = $cardIdentifier;
            $card->financialInstrument()
                ->associate($financialInstrument);
            $card->save();
        }

        $response['financial_instrument'] = $financialInstrument;

        return response()
            ->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $financialInstrument = FinancialInstrument::findOrFail($id);
            $response['financial_instrument'] = $financialInstrument;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $accountId
     * @return \Illuminate\Http\Response
     */
    public function showByAccount($accountId)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $account = Account::findOrFail($accountId);
            $financialInstruments = $account->financialInstruments;
            
            foreach ($financialInstruments as $key => $fi){
                $cards = Card::where('financial_instrument_id', $fi->id)
                    ->get();
                if ($cards != null){
                    $fi->cards = $cards;
                    $financialInstruments[$key] = $fi;
                }
            }
            
            $response['financial_instruments'] = $financialInstruments;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
