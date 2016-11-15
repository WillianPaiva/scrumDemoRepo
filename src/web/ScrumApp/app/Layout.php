<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    //
    public function Sprint()
    {
        return $this->belongsTo('App\Sprint');
    }
}
