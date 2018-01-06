<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\FinancialInstrument;
use App\Http\Controllers\Controller;
use App\Place;
use App\Transaction;
use App\TransactionCategory;
use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;

//use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Transaction::with(['category', 'financialInstrument'])->get());
        $transactions = Transaction::where('account_id', $user->account->id);
        $transactions->load('category');
        return response()->json($transactions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $title = $request->get('title', '');
        $amount = $request->get('amount', 0.0);
        $financialInstrumentId = $request->get('financial_instrument_id');
        $transactionCategoryId = $request->get('transaction_category_id');
        $googlePlaceId = $request->get('google_place_id');

        $financialInstrument = FinancialInstrument::findOrFail($financialInstrumentId);
        $transactionCategory = TransactionCategory::findOrFail($transactionCategoryId);
        $place = Place::where('google_place_id', $googlePlaceId)->first();

        if($place == null) {
            $placeInfo = $this->getGooglePlaceInfoFromService($googlePlaceId);
            $place = new Place;
            $place->google_place_id = $googlePlaceId;
            $place->name = $placeInfo['result']['name'];
            $place->lat = $placeInfo['result']['geometry']['location']['lat'];
            $place->lon = $placeInfo['result']['geometry']['location']['lng'];
            $place->save();
        }

        $transaction = new Transaction;
        $transaction->title = $title;
        $transaction->amount = doubleval($amount);

        $transaction->financialInstrument()
            ->associate($financialInstrument);

        $transaction->category()
            ->associate($transactionCategory);

        $transaction->place()
            ->associate($place);

        $transaction->save();

        return response()->json([
            'ok' => 1,
            'transaction' => $transaction
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    protected function getGooglePlaceInfoFromService($googlePlaceId)
    {
        $maps = new GoogleMaps;
        $response = $maps->load('placedetails')
            ->setParam([
                'placeid' => $googlePlaceId,
                'language' => 'es',
            ])
            ->get();
        return \GuzzleHttp\json_decode($response, true);
    }
}
