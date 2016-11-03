@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">New Project</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="addProject">
                         {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description" class="col-md-4 control-label">Description</label>

                            <div class="col-md-6">
                                <textarea id="description" class="form-control" name="description" value="" required></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="language" class="col-md-4 control-label">Language</label>

                            <div class="col-md-6">
                                <input id="language" type="text" class="form-control" name="language" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="version" class="col-md-4 control-label">Version</label>

                            <div class="col-md-6">
                                <input id="version" type="text" class="form-control" name="version" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Add
                                </button>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
