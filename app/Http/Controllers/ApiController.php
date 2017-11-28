<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('api');
    }

    public function register(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $account = Account::make();
        $account->type()->associate(AccountType::find('1'));
        $account->save();

        $user = User::make([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        $user->account()
            ->associate($account)
            ->save();
        return $user;
    }
}
