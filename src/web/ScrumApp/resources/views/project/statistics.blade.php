@extends('layouts.app')

@section('content')
    <div id="stats">
        <stats :id="{{ $id }}"></stats>
    </div>
@endsection
