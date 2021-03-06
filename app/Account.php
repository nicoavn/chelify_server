<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/11/2017
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function type()
    {
        return $this->belongsTo('App\AccountType', 'account_type_id');
    }
}