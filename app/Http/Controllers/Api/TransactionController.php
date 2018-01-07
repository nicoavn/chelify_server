<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\FinancialInstrument;
use App\Http\Controllers\Controller;
use App\Place;
use App\Transaction;
use App\TransactionCategory;
use GoogleMaps\GoogleMaps;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

        try {
            $financialInstrument = FinancialInstrument::findOrFail($financialInstrumentId);
            $transactionCategory = TransactionCategory::findOrFail($transactionCategoryId);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'ok' => 0,
                'error' => $e->getMessage()
            ]);
        }

        $place = Place::where('google_place_id', $googlePlaceId)->first();

        if ($place == null) {
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
        $response = [
            'ok' => 1
        ];
        try {
            $transaction = Transaction::findOrFail($id);
            $response['transaction'] = $transaction;
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
            $response['transactions'] = $account->transactions;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    public function monthSummary($accountId)
    {
        $account = Account::findOrFail($accountId);

        $now = Carbon::now();
        $startDate = $now->firstOfMonth()->toDateTimeString();
        $endDate = $now->lastOfMonth()->toDateTimeString();

        return response()->json(self::summary($account, $startDate, $endDate));
    }

    /**
     * @param $account
     * @param $startDate
     * @param $endDate string
     * @param $category TransactionCategory
     * @return Collection Collection
     */
    public static function summary($account, $startDate, $endDate, $category = null)
    {
        $query = DB::table('transactions AS t')
            ->join('transaction_categories AS tc', 't.transaction_category_id', '=', 'tc.id')
            ->join('financial_instruments AS fi', 't.financial_instrument_id', '=', 'fi.id')
            ->where('fi.account_id', "=", $account->id)
            ->whereBetween('t.created_at', [$startDate, $endDate]);

        if($category != null)
            $query->where('transaction_category_id', '=', $category->id);
        else
            $query->groupBy('transaction_category_id');

        return $query->select(DB::raw('tc.name'), DB::raw('SUM(t.amount) as total'))->get();
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
