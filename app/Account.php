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

class Account extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function transactions()
    {
        return $this->hasMany('App\Transactions');
    }

    public function type()
    {
        return $this->belongsTo('App\AccountType', 'account_type_id');
    }

    public function cards()
    {
        return $this->hasManyThrough('App\Card', 'App\FinancialInstrument');
    }

    public function financialInstruments()
    {
        return $this->hasMany('App\FinancialInstrument', 'owner_id');
    }

    public function images()
    {
        return $this->hasMany('App\Image');
    }

    public function __toString()
    {
        return "Account ID: " . $this->id;
    }
}