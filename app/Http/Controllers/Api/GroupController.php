<?php

namespace App\Http\Controllers\Api;

use App\Account;
use App\AccountType;
use App\Group;
use App\Http\Controllers\Controller;
use App\User;
use DateTime;
use Exception;
use Illuminate\Http\Request;

class GroupController extends Controller
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
        return response()->json(Group::with(['manager', 'users', 'account.images'])->get());
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $account = Account::make();
        $account->type()->associate(AccountType::find('2'));
        $account->save();

        $group = Group::make([
            'title' => $data['title'],
            'manager_id' => $data['manager_id'],
        ]);

        $group->account()
            ->associate($account)
            ->save();

        return $group;
    }

    public function addMember(Request $request)
    {
        $response = ['ok' => 1];

        $data = $request->all();

        try {
            $user = User::find($data['user_id'])->first();
            $group = Group::find($data['group_id'])->first();
            $dt = new DateTime;
            $group->users()->attach($user, ['created_at' => $dt->format('Y-m-d H:i:s')]);
        } catch (Exception $e) {
            $response['ok'] = 0;
            $response['error'] = $e->getMessage();
        }


        return response()->json($response);
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
