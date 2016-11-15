<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{

        protected $fillable = [
        'id',
        'name',
        'date_begin',
        'date_estimated',
        'project_id',

    ];


    public function UserStorys()
    {
        return $this->hasMany('App\UserStory');
    }
    public function Collunms()
    {
        return $this->hasMany('App\Layout');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
