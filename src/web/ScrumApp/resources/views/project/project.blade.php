@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$project->name}}</div>
                <div class="panel-body">
                    <label for="language" class="col-md-4 control-label">Desciption</label>
                    </br>
                    <div class="well">{{ $project->description }}</div>
                    <label for="language" class="col-md-4 control-label">Language</label>
                    </br>
                    <div class="well">{{ $project->language }}</div>
                    <label for="language" class="col-md-4 control-label">Version</label>
                    </br>
                    <div class="well">{{ $project->version }}</div>
                    <label for="language" class="col-md-4 control-label">Owner</label>
                    </br>
                    <div class="well">{{ App\User::find($project->user_id)->name }}</div>

                    <label for="language" class="col-md-4 control-label">Members</label>
                    </br>
                    <div id="memb" >
                        <adduser  v-bind:membs="members" :pid="{{ $project->id }}"></adduser>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
