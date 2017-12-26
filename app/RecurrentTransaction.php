<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecurrentTransaction extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

}
