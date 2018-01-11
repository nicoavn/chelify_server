<?php

namespace App\Http\Controllers\Api;

use App\RecurrentTransaction;
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
