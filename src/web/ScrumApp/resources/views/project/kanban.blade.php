@extends('layouts.app')

@section('content')


<div id="boardWrapper">
    <kanban :sprintid="{{$id}}"></kanban>
</div>

@endsection
