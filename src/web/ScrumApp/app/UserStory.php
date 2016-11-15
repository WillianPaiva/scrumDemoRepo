<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStory extends Model
{
    //

    protected $fillable = [
        'id',
        'description',
        'status',
        'commit',
        'date_begin',
        'date_estimated',
        'date_finished',
        'effort',
        'priority',
        'project_id',
        'sprint_id',
    ];
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function sprint()
    {
        return $this->belongsTo('App\Sprint');
    }
    public function Tasks()
    {
        return $this->hasMany('App\Task');
    }
}
