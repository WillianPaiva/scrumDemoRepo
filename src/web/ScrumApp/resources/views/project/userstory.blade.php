
@extends('layouts.app')

@section('content')
    <div id="userstory">
        <showus :id="{{ $id }}" :nb="{{ $nb}}"></showus>
    </div>
</script>
@endsection
