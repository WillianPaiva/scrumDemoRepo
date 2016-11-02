@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">User Profile</div>
                <div class="panel-body">
                    <table class="table table-hover">
                    <tr>
                        <td>Nom:</td>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td> {{ Auth::user()->email }}</td>
                    </tr>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>

@endsection
