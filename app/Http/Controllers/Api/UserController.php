<?php

namespace App\Http\Controllers\Api;

use App\Transaction;
use App\TransactionCategory;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function info($userId)
    {
        $user = User::findOrFail($userId);
        $user->load(['account.images']);
        return response()->json($user);
    }

    public function monthSummary($userId)
    {
        $user = User::findOrFail($userId);

        $now = Carbon::now();
        $startDate = $now->firstOfMonth()->toDateTimeString();
        $endDate = $now->lastOfMonth()->toDateTimeString();

//        DB::enableQueryLog();
//        self::summary($user->account, $startDate, $endDate);
//        $queries = DB::getQueryLog();
//        dd(end($queries)); // only last query

        return response()->json(self::summary($user->account, $startDate, $endDate));
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
        //
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
