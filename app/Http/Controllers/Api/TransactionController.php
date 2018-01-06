<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Place;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $account_id = $request->get('account_id', '');
        $title = $request->get('title', '');
        $amount = $request->get('amount', 0.0);
        $financialInstrumentId = $request->get('financial_instrument_id');
        $transactionCategory = $request->get('transaction_category_id');
        $googlePlaceId = $request->get('google_place_id');
        $place = $request->get('place_name');
        $placeName = $request->get('place_name');

        $account = Account::findOrFail($account_id);

        $place = Place::findOrNew('google_place_id', $googlePlaceId);
        $place->name = $placeName;
        $place->save();

        $transaction = new Transaction;
    }

    protected function getGooglePlaceInfoFromService ($googlePlaceId)
    {
        $key = 'AIzaSyBbekjFSn_eP7arUVSw6fnnGSilkYfAMAc';
        $queryString = "placeid={$googlePlaceId}&language=es&key={$key}";
        $url = 'https://maps.googleapis.com/maps/api/place/details/json?' . $queryString;

        $placeInfo = json_decode($output, true);
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
}
