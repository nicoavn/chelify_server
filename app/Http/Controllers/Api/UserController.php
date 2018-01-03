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

        dd(self::summary($user->account, $startDate, $endDate));
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
            ->where('t.account_id', "=", $account->id)
            ->whereBetween('t.created_at', [$startDate, $endDate]);

        if($category != null)
            $query->where('transaction_category_id', '=', $category->id);

        return $query->get();
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
