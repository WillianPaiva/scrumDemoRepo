<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'project_user');
    }

}
