<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    //
  protected $fillable = [
      'id',
      'name',
      'position',
      'sprint_id',
                         ];
    public function Sprint()
    {
        return $this->belongsTo('App\Sprint');
    }
}
