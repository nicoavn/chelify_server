<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\Http\Controllers\Controller;
use App\Report;
use App\TransactionCategoryType;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    const GROUP_BY_CATEGORIES = 'categories';
    const GROUP_BY_FINANCIAL_INSTRUMENTS = 'financial_instruments';
    const GROUP_BY_PLACES = 'places';
    const GROUP_BY_MONTH = 'month';

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            $report = Report::findOrFail($id);
            $response['transaction'] = $report;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    public function showByAccount($accountId)
    {
        $response = [
            'ok' => 1
        ];
        try {
            $account = Account::findOrFail($accountId);
            $response['reports'] = $account->reports;
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }
        return response()
            ->json($response);
    }

    public function build(Request $request)
    {
        $parameters = $request->all();

        $response = [
            'ok' => 1
        ];

        $report = new Report;

        try {
            $account = Account::findOrFail($request->get('account_id', 'null'));
        } catch (ModelNotFoundException $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }

        $transactionCategoryType = null;
        if (!empty($parameters['transaction_category_type_id']))
            $transactionCategoryType = TransactionCategoryType::find($parameters['transaction_category_type_id']);

        $startDate = null;
        $endDate = null;
        if (!empty($parameters['start_date']) && !empty($parameters['end_date']))
            try {
                $startDate = Carbon::createFromFormat("Y-m-d", $parameters['start_date']);
                $endDate = Carbon::createFromFormat("Y-m-d", $parameters['end_date']);
            } catch (Exception $e) {
                $startDate = null;
                $endDate = null;
                // ignore
            }

        $groupBy = null;
        if (!empty($parameters['group_by']))
            $groupBy = $parameters['group_by'];

        $report->account()
            ->associate($account);

        $report->transactionCategoryType()
            ->associate($transactionCategoryType);

        $report->from_date = $startDate->toDateTimeString();
        $report->to_date = $endDate->toDateTimeString();
        $report->group_by = $groupBy;

        $response['result'] = $this->runReport($report);
        return response()
            ->json($response);
    }

    public function buildById($reportId)
    {
        $response = [
            'ok' => 1
        ];

        try {
            $report = Report::findOrFail($reportId);
            $response['report'] = $report;
        } catch (ModelNotFoundException $e) {
            return response()
                ->json([
                    'ok' => 0,
                    'error' => $e->getMessage()
                ]);
        }

        try {
            $response['result'] = $this->runReport($report);
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
            return response()->json($response);
        }

        return response()
            ->json($response);
    }

    public function runReport(Report $report)
    {
        $account = Account::findOrFail($report->account_id);

        $transactionCategoryType = null;
        if (!empty($report->transaction_category_type_id))
            $transactionCategoryType = TransactionCategoryType::find($report->transaction_category_type_id);

        $startDate = null;
        $endDate = null;
        if (!empty($report->from_date) && !empty($report->to_date))
            try {
                $startDate = Carbon::createFromFormat("Y-m-d", $report->from_date);
                $endDate = Carbon::createFromFormat("Y-m-d", $report->to_date);
            } catch (Exception $e) {
                $startDate = null;
                $endDate = null;
                // ignore
            }

        $groupBy = null;
        if (!empty($report->group_by))
            $groupBy = $report->group_by;

        $query = DB::table('transactions AS t')
            ->join('financial_instruments AS fi', 't.financial_instrument_id', '=', 'fi.id')
            ->where('fi.account_id', "=", $account->id);

        $result = null;

        if (!empty($startDate) && !empty($endDate))
            $query->whereBetween('t.created_at', [$startDate->toDateTimeString(), $endDate->toDateTimeString()]);

        if ($transactionCategoryType != null) {
            $query->join('transaction_categories AS tc', 't.transaction_category_id', '=', 'tc.id')
                ->join('transaction_category_types AS tct', 'tc.transaction_category_type_id', '=', 'tct.id');
            $query->where('tc.transaction_category_type_id', '=', $transactionCategoryType->id);
            $result = $query->select(DB::raw('tct.name'), DB::raw('SUM(t.amount) AS total'));
        } else {
            switch ($groupBy) {
                case self::GROUP_BY_CATEGORIES:
                    $query->join('transaction_categories AS tc', 't.transaction_category_id', '=', 'tc.id');
                    $query->groupBy('t.transaction_category_id');
                    $result = $query->select(DB::raw('tc.name'), DB::raw('SUM(t.amount) AS total'));
                    break;
                case self::GROUP_BY_FINANCIAL_INSTRUMENTS:
                    $query->groupBy('t.financial_instrument_id');
                    $query->join('financial_instrument_types AS fit', 'fi.financial_instrument_type_id', '=', 'fit.id');
                    $result = $query->select(DB::raw('fi.identifier'), DB::raw('SUM(t.amount) AS total'), DB::raw('fit.name AS type'));
                    break;
                case self::GROUP_BY_MONTH:
                    $query->groupBy(DB::raw('DATE_FORMAT(t.created_at, "%Y-%m-01")'));
                    $result = $query->select(DB::raw('DATE_FORMAT(t.created_at, "%Y-%m-01") AS month'), DB::raw('SUM(t.amount) AS total'));
                    break;
                case self::GROUP_BY_PLACES:
                    $query->leftJoin('places AS p', 't.place_id', '=', 'p.id');
                    $query->groupBy('t.place_id');
                    $result = $query->select(DB::raw('IF(p.name IS NULL, "", p.name) AS place'), DB::raw('SUM(t.amount) AS total'));
                    break;
            }
        }

        DB::enableQueryLog();
        $result->get();
        //return $result->get();
        dd(DB::getQueryLog());
        return  null;
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
