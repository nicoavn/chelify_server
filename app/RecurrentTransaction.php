<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecurrentTransaction extends Model
{
    use SoftDeletes;

    const RECURRENT_TRANSACTION_CATEGORY = 'recurrent';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
