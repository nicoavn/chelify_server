<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function account()
    {
        return $this->belongsTo('App\Account');
    }

    public function transactionCategoryType()
    {
        return $this->belongsTo('App\TransactionCategoryType');
    }
}
