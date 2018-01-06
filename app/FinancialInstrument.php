<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialInstrument extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function account()
    {
        return $this->belongsTo('App\Account', 'owner_id');
    }

    public function type()
    {
        return $this->belongsTo('App\FinancialInstrumentType', 'financial_instrument_type_id');
    }

    public function financialEntity()
    {
        return $this->belongsTo('App\FinancialEntity');
    }
}
