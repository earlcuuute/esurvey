<div id="question{{ $question->id }}" class="row question-row editable" data-toggle="modal" data-target="#add-question-modal" data-question-id="{{ $question->id }}" data-question-type="{{ $question->questionType()->first()->id }}">
    <div class="col-xs-6">
        <div class="form-group">
            <label class="editable">
                <h3>
                    <span class="question-number"></span>
                    <span class="question-dot">.</span>
                    <span class="question-title">{{ $question->question_title }}</span>
                </h3>
            </label>
            @if($question->questionType()->first()->has_choices)
                @if($question->questionType()->first()->type == "Multiple Choice")
                    @foreach($question->choices()->get() as $choice)
                        <div class="radio">
                            <label> <input type="radio"> {{ $choice->label }}</label>
                        </div>
                    @endforeach
                @elseif($question->questionType()->first()->type == "Dropdown")
                    <select class="form-control">
                        @foreach($question->choices()->get() as $choice)
                            <option>{{ $choice->label }}</option>
                        @endforeach
                    </select>
                @endif

            @else
                {!!  $question->questionType()->first()->html  !!}
            @endif

        </div>
    </div>
</div>