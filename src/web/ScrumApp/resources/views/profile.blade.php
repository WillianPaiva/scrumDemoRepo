@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="/uploads/avatars/{{ $user->avatar }}" class="img-circle">
            <h2>{{ $user->name }}'s Profile</h2>
            <h2> Contact: {{ $user->email }}</h2>
            <form id="form" enctype="multipart/form-data" action="/profile" method="POST">
                <label>Update Profile Image</label>
                <label class="btn btn-default btn-file">
    Browse <input type="file"  name="avatar" style="display: none;" onchange="javascript:document.getElementById('form').submit();">
</label>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

            </form>
        </div>
        <div class="col-md-10 col-md-offset-1">
          Projects contributing at:
          @if(count($memberOf)==0 && count($owns)==0)
          <h2> No Projects </h2>
          @else
          <table class="table table-hover">
            <tr> <th>Name</th><th>description</th><th>Language</th><th>Version</th><th>Position</th>
            </tr>
            @foreach ($owns as $owns)
            @foreach ($memberOf as $memberOf)
            @if($memberOf->name==$owns->name)
            @continue
            @else
              <tr>
                  <td>{{$memberOf->name}}</td>
                  <td>{{$memberOf->description}}</td>
                  <td>{{$memberOf->language}}</td>
                  <td>{{$memberOf->version}}</td>
                  <td>Member</td>
              </tr>
                @endif
                @endforeach
              <tr>
                    <td>{{$owns->name}}</td>
                    <td>{{$owns->description}}</td>
                    <td>{{$owns->language}}</td>
                    <td>{{$owns->version}}</td>
                    <td>Owner</td>
                </tr>

                  @endforeach
          </table>
          @endif
        </div>
    </div>
</div>

@endsection
