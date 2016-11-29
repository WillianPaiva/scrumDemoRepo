
@extends('layouts.app')

@section('content')
    <div id="backlog">
        <backlog :id="{{ $id }}"></backlog>
    </div>
@endsection
