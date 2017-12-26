<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/11/2017
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class TransactionCategory extends Model
{
    public function type()
    {
        return $this->belongsTo('App\TransactionCategoryType', 'transaction_category_type_id');
    }
}