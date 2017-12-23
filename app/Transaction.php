<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/11/2017
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function category()
    {
        return $this->belongsTo('App\TransactionCategory', 'transaction_category_id');
    }
}