@extends('layouts.app')

@section('header','My Surveys')

@section('content')
    <div class="form-group">
        <a href="{{ url('/create') }}" class="btn btn-lg btn-danger" data-toggle="tooltop" title="Delete this survey"><i class="fa fa-plus"></i>New Survey</a>
    </div>

<table class="dataTable table table-bordered">
    <thead>
        <tr>
            <td width="30%">Title</td>
            <td>Responses</td>
            <td>Edit</td>
            <td>Analyze</td>
            <td>Delete</td>
        </tr>
    </thead>
    <tbody>
        @foreach($surveys as $survey)
            <tr>
                <td>{{ $survey->survey_title }}</td>
                <td class="text-center"> <h4 >0</h4> </td>
                <td class="text-center"> <a href="{{ url('/create/'.$survey->id) }}" class="btn btn-primary">Edit</a> </td>
                <td class="text-center"> <a href="#" class="btn btn-warning">Analyze</a>  </td>
                <td class="text-center">
                    <form method="POST" action="{{ url('/create/'.$survey->id) }}">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger" data-toggle="tooltop" title="Delete this survey">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
