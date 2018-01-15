<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupUser extends Pivot
{
    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
