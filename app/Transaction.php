<?php
/**
 * Created by PhpStorm.
 * User: alvin
 * Date: 21/11/2017
 * Time: 6:55 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\TransactionCategory', 'transaction_category_id');
    }

    public function financialInstrument()
    {
        return $this->belongsTo('App\FinancialInstrument', 'financial_instrument_id');
    }

    public function place()
    {
        return $this->belongsTo('App\Place');
    }
}