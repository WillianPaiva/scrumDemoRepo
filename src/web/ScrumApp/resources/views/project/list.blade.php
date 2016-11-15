@extends('layouts.app')

@section('content')
    <div id="projects">
        <projects :user="{{ Auth::User()->id }}"></projects>
    </div>
</script>
@endsection
