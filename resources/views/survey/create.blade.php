@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-xs-offset-1 col-xs-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Build New Survey</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="{{ url('/create') }}" role="form" method="POST">

                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                        <label for="title" class="col-md-4 control-label">Title* </label>

                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control" name="survey_title" maxlength="250" placeholder="Title of your survey" value="{{ old('title') }}">


                        <span class="help-block">
                            @if ($errors->has('title'))
                                 <strong>{{ $errors->first('title') }}</strong>
                            @else
                                <small>Up to 250 characters</small>
                            @endif
                        </span>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-6">
                            <select class="form-control" name="category">
                                <option value="-1" selected>Select Category</option>
                                <optgroup label="Categories">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->category }}
                                        </option>
                                    @endforeach
                                </optgroup>

                                <option value="0">Other</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-offset-4 col-xs-6">
                            <button type="submit" class="btn btn-facebook">Create</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection