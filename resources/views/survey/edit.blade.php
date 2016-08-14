@extends('layouts.app')

@section('content')

@include('modals.surveyTitle')

@include('modals.pageTitle')

@include('modals.question')

<input type="hidden" id="selected-page-id" value="0">

<div class="col-xs-offset-1 col-xs-10">
    <?php $questionNo = 1; ?>
    @foreach($survey->pages()->orderBy('page_no')->get() as $page)
        <div id="pageid{{ $page->id }}" class="page-row" data-page-number="{{ $page->page_no }}" data-id="{{ $page->id }}" data-title="{{ $page->page_title }}" data-description="{{ $page->page_description }}">
            <h4 class="page-no">Page {{ $page->page_no }}</h4>
            <div class="panel panel-default">

                <div class="panel-heading editable survey-title" data-toggle="modal" data-target="#survey-title-modal" value="{{ $survey->survey_title }}">
                    {{ $survey->survey_title }}
                </div>

                <div class="panel-heading edit-page-title editable" data-toggle="modal" data-target="#page-title-modal" data-identifier="title">
                    @if($page->page_title == "" || $page->page_title == null)
                        <span class="glyphicon glyphicon-plus"></span>
                        Add Page Title
                    @else
                        {{ $page->page_title }}
                    @endif
                </div>

                <div class="panel-body">

                    <div class="row edit-page-description editable" data-toggle="modal" data-target="#page-title-modal" data-identifier="description">
                        <div class="col-xs-12">
                            <p class="page-description">{{ $page->page_description }}</p>
                        </div>
                    </div>

                    <div class="question-container">
                        {{--AJAX WILL APPEND COMPONENTS HERE--}}
                        @foreach($page->questions()->get() as $question)
                            <div class="question-row-container">
                                <div class="question-row-tools editable"  data-toggle="modal" data-target="#add-question-modal">
                                    <div class="col-xs-offset-6 col-xs-6">
                                        <div class="question-actions">
                                            <button type="button" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>

                                <div id="question{{ $question->id }}" class="row question-row" data-question-id="{{ $question->id }}" data-question-number="{{ $questionNo }}" data-question-type="{{ $question->questionType()->first()->id }}" data-has-choices="{{ $question->questionType()->first()->has_choices }}">
                                    <div class="col-xs-6 height-adjuster">
                                        <div class="form-group">
                                            <label>
                                                <h3>
                                                    <span class="question-number">{{ $questionNo++ }}</span>
                                                    <span class="question-dot">.</span>
                                                    <span class="question-title">{{ $question->question_title }}</span>
                                                </h3>
                                            </label>

                                            @if($question->questionType()->first()->has_choices)
                                                @if($question->questionType()->first()->type == "Multiple Choice")
                                                    @foreach($question->choices()->get() as $choice)
                                                        <div class="radio choice-row" data-choice-id="{{ $choice->id }}">
                                                            <label class="choice-label"> <input type="radio"> {{ $choice->label }}</label>
                                                        </div>
                                                    @endforeach
                                                @elseif($question->questionType()->first()->type == "Dropdown")
                                                    <select class="form-control">
                                                        @foreach($question->choices()->get() as $choice)
                                                            <option class="choice-row choice-label" data-choice-id="{{ $choice->id }}">{{ $choice->label }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                            @else
                                                {!!  $question->questionType()->first()->html  !!}
                                            @endif

                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endforeach
                    </div>

                    <div class="row">
                        <div class="btn-group col-xs-offset-4">
                            <button type="button" class="btn btn-primary add-question" data-toggle="modal" data-target="#add-question-modal"  data-question-number="{{ $questionNo }}" data-page="{{ $page->page_no }}"><i class="fa fa-plus-circle"></i> Add new Question</button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" data-question-number="{{ $questionNo }}"><span class="fa fa-caret-down"></span></button>
                                <ul class="dropdown-menu">
                                    @foreach($question_types as $question_type)
                                        <li class="type-option"><a href="#" id="{{ $question_type->id }}" has-choices="{{ $question_type->has_choices }}">{{ $question_type->type }}</a></li>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-lg btn-default add-page col-xs-12" type="button"><span class="fa fa-plus-square-o"></span> Add Page</button>
            </div>

        </div>
    @endforeach

</div>
@endsection