<!-- Add Question Modal -->
<div class="modal fade" id="add-question-modal" tabindex="-1" page="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Customize your question</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xs-12" style="margin-top: 10px; ">
                        <div class="panel panel-default">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#question" aria-controls="home" role="tab" data-toggle="tab">Question</a></li>
                                <li role="presentation"><a href="#settings" aria-controls="profile" role="tab" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-content panel-body">

                                <div role="tabpanel" class="tab-pane active" id="question">
                                    <form id="question-modal-form" class="form-horizontal" role="form">

                                        <div class="form-group">
                                            <div class="col-xs-4">
                                                <select id="question-type-select" class="form-control btn btn-default">
                                                    @foreach($question_types as $question_type)
                                                        <option class="type-option" value="{{ $question_type->id }}" has-choices="{{ $question_type->has_choices }}">{{ $question_type->type }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-xs-1 control-label" for="question-title"><strong id="modal-question-number">Q1:</strong></label>
                                            <div class="col-xs-11">
                                                <input type="text" id="question-title" name="question-title" placeholder="Enter Question Title" class="form-control" required>
                                                <span class="help-block">
                                                    <small><strong>error here</strong></small>
                                                </span>
                                            </div>

                                        </div>

                                        <div id="choice-container" class="collapse">
                                            <hr>
                                            <strong>Answer Choices</strong>

                                            <table id="modal-choices-table" class="choices-table">

                                                <tr class="modal-choice-row">
                                                    <td class="question-type">
                                                        <input type="radio" disabled>
                                                    </td>
                                                    <td width="100%">
                                                        <input type="text" placeholder="Enter Choice Label" class="form-control modal-choice-label">
                                                    </td>
                                                    <td>
                                                        <button type="button" tabindex="-1" class="btn btn-primary add-choice"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" tabindex="-1" class="btn btn-danger remove-choice"><span class="glyphicon glyphicon-remove"></span></button>
                                                    </td>
                                                </tr>

                                                <tr class="modal-choice-row">
                                                    <td class="question-type">
                                                        <input type="radio" disabled>
                                                    </td>
                                                    <td width="100%">
                                                        <input type="text" placeholder="Enter Choice Label" class="form-control modal-choice-label">
                                                    </td>
                                                    <td>
                                                        <button type="button" tabindex="-1" class="btn btn-primary add-choice"><span class="glyphicon glyphicon-plus"></span></button>
                                                    </td>
                                                    <td>
                                                        <button type="button" tabindex="-1" class="btn btn-danger remove-choice"><span class="glyphicon glyphicon-remove"></span></button>
                                                    </td>
                                                </tr>

                                            </table>

                                        </div>

                                    </form>
                                </div>

                                <div role="tabpanel" class="tab-pane" id="settings">

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" tabindex="-1" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-facebook" id="save-question">Save Question</button>
            </div>
        </div>
    </div>
</div>