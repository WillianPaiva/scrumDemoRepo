<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'commit',
        'priority',
        'cost',
        'date_begin',
        'date_estimated',
        'date_finished',
        'user_story_id',
    ];

    public function UserStory()
    {
        return $this->belongsTo('App\UserStory');
    }
}
