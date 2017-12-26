<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
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
        return $this->belongsTo('App\Account');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'manager_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
