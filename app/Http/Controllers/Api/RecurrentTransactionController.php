<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\RecurrentTransaction;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RecurrentTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(RecurrentTransaction::with('chargeTo')->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dayOfMonth = $request->get('day_of_month', '');
        $amount = $request->get('amount', 0.0);
        $title = $request->get('title', '');

        $chargeTo = $request->get('financial_instrument_id');

        $recurrentTransaction = new RecurrentTransaction;
        $recurrentTransaction->day_of_month = $dayOfMonth;
        $recurrentTransaction->amount = $amount;
        $recurrentTransaction->title = $title;
        $recurrentTransaction->charge_to = $chargeTo;
        $recurrentTransaction->save();

        return response()->json([
            'ok' => 1,
            'recurrent_transaction' => $recurrentTransaction
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $recurrentTransaction = RecurrentTransaction::findOrFail($id);
            $recurrentTransaction->load('chargeTo');
            $response['recurrent_transaction'] = $recurrentTransaction;
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

            $recurrentTransactions = RecurrentTransaction::where('account_id', $account->id);

            $response['recurrent_transactions'] = $recurrentTransactions;
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $recurrentTransaction = RecurrentTransaction::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'ok' => 0,
                'error' => $e->getMessage()
            ]);
        }

        $recurrentTransaction->delete();

        return response()->json([
            'ok' => 1
        ]);
    }
}
