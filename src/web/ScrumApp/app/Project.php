<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','user_id','description', 'language','version',
    ];

    public function owner()
    {
        return $this->belongsTo('App\User');
    }

    public function members()
    {
        return $this->belongsToMany('App\User', 'project_user');
    }


    public function UserStorys()
    {
        return $this->hasMany('App\UserStory');
    }

    public function Sprints()
    {
        return $this->hasMany('App\Sprint');
    }
}
