var selectedChoiceType;
var choiceCount;
var pageCount;
var questionRowIsClicked = false;

$(function () {
    //init
    init();

    /**************************************************************************************************************
     *                                      QUESTION MANIPULATION                                                     *
     *************************************************************************************************************/

    //EDITING SURVEY TITLE
    $('.survey-title').click(function () {
        $('#survey-title').val($(this).attr('value'));

    });

    $('#survey-title-modal').on('shown.bs.modal', function (event) {
        $('#survey-title').focus();
    });

    $('#save-survey-title').click(function () {
        $.ajax({
            type: 'POST',
            data: {
                action: 'edit_survey_title',
                survey_title: $('#survey-title').val()
            },
            beforeSend: function(){
                loadingToast('Saving Survey Title');
            },
            success: function (data) {
                $('.jq-toast-wrap').remove();

                $('.survey-title').each(function () {
                    $(this).html($('#survey-title').val());
                });

                $('#survey-title-modal').modal('hide');
                successToast('Title Updated');
            },
            error: function(data){
                console.log(data);
                errorToast();
            }
        });
    });

    //adding question from dropdown menu
    $('.type-option a').click(function () {
        console.log('earl is real');
    });

    $('#question-type-select').on('change',function(){
        toggleAnswerChoices();
    });

    //SET PAGE DATA TO MODAL
    $('.add-question').click(function () {
        if(questionRowIsClicked){
            $('#question-modal-form')[0].reset();
        }
        questionRowIsClicked = false;
        $('#save-question').attr('method', 'add');
        showAddQuestionModal($(this), $(this).data('question-number'));
        toggleAnswerChoices();
    });

    //ADDING NEW CHOICE

    $('#add-question-modal .add-choice').click(function(){
        row = $(this).closest('tr');
        rowCopy = row.clone(true);
        choiceLabel = rowCopy.find('.modal-choice-label').val('');
        row.after(rowCopy);
        choiceLabel.focus();
        ++choiceCount;
    });

    //REMOVING CHOICE

    $('#add-question-modal .remove-choice').click(function(){
        if(choiceCount>2){
            $(this).closest('tr').remove();
            --choiceCount;
        }
    });

    //SAVING QUESTION

    $('#save-question').click(function(){
        pageId = $('#selected-page-id').val();
        manipulationMethod = $(this).attr('method');
        questionID = $(this).data('question-id');
        choices = [];
        if(selectedChoiceType.attr('has-choices')==1){
            $.each($('.modal-choice-label'), function () {
                choices.push($(this).val());
            });
        }
        $.ajax({
            type: 'PUT',
            data: {
                manipulation_method: manipulationMethod,
                question_id: questionID,
                question_title: $('#question-title').val(),
                question_type: $('#question-type-select').val(),
                page_id: pageId,
                choices: choices
            },
            success: function (data) {
                // console.log(data);
                if(manipulationMethod == "add"){
                    page = getPage(pageId);
                    page.find('.question-container').append(data);
                    last = page.find('.question-container .question-row').last();
                    last.click(function () {
                        addQuestion($(this));
                    });
                }else if(manipulationMethod == "edit"){
                    $('#question'+questionID).replaceWith(data);
                }
                updateQuestionNumbers();

                //RESET MODAL
                $('#add-question-modal').modal('hide');
                successToast();
            },
            error: function(data){
                response = $.parseJSON(data.responseText);
                errorToast();
                if(response.hasOwnProperty('title')){
                    console.log(response.title);
                }
            }
        });
    });
    
    //EDITING QUESTION
    
    $('.question-row-tools').click(function(){
        questionRow = $(this).parent().find('.question-row');
        addQuestion(questionRow);
        questionRowIsClicked = true;

        if(questionRow.data('has-choices') == 1){
            //COPYING CURRENT CHOICES TO MODAL
            rowChoiceDiv = $('.modal-choice-row').first().clone(true);
            $('#modal-choices-table').html("");
            $.each(questionRow.find($('.choice-label')), function () {
                console.log('earl is real');
                choice = rowChoiceDiv.clone();
                choice.find('.modal-choice-label').val($(this).text());
                $('#modal-choices-table').append(choice);
            });
        }



    });

    $('#add-question-modal').on('shown.bs.modal', function (event) {
        $('#question-title').focus();
        // console.log($('#save-question').data('question-id'));
    });


    /**************************************************************************************************************
     *                                   END QUESTION MANIPULATION                                                *
     *************************************************************************************************************/

    /**************************************************************************************************************
     *                                      PAGE MANIPULATION                                                     *
     *************************************************************************************************************/

    $('.edit-page-description, .edit-page-title').click(function () {
        $('#selected-page-id').val($(this).closest('.page-row').data('id'));
        $('#page-description').val($(this).closest('.page-row').data('description'));
        $('#page-title').val($(this).closest('.page-row').data('title'));
    });

    $('#page-title-modal').on('shown.bs.modal', function (event) {
        target = $(event.relatedTarget);

        page = target.closest('.page-row');

        if(target.data('identifier')=="title"){
            $('#page-title').focus();
        }else{
            $('#page-description').focus();
        }

    });

    $('#save-page-title').click(function () {
        page = getPage($('#selected-page-id').val());
        console.log($("#selected-page-id").val());
        console.log($('#page-title').val());
        console.log($('#page-description').val());
        $.ajax({
            type: 'POST',
            data: {
                action: 'edit_page_title',
                page_id: $("#selected-page-id").val(),
                page_title: $('#page-title').val(),
                page_description: $('#page-description').val()
            },
            beforeSend: function(){
                loadingToast('Saving Page Title');
            },
            success: function (data) {
                $('.jq-toast-wrap').remove();
                console.log(data);
                $('#page-title-modal').modal('hide');
                page.data('title', $('#page-title').val());
                page.data('description', $('#page-description').val());
                page.find($('.edit-page-title')).html($('#page-title').val());
                page.find($('.page-description')).html($('#page-description').val());
            },
            error: function(data){
                response = $.parseJSON(data.responseText);
                errorToast();
                // if(response.hasOwnProperty('title')){
                //     console.log(response.title);
                // }
            }
        });
    });

    $('.add-page').click(function () {
        page = $(this).closest('.page-row');
        console.log(page.data('page-number'));
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: {
                action: 'add_page',
                page_no: page.data('page-number')
            },
            beforeSend: function(){
                loadingToast('Adding New Page');
            },
            success: function (data) {
                console.log(data);
                pageCopy = $('.page-row').first().clone(true).data('id', data.id).attr('id', 'pageid' + data.id);
                page.after(pageCopy.find('.question-container').html(''));

                updatePageNumbers();
                successToast('New Page Added!');
            },
            error: function(data){
                console.log(data);
                errorToast();
            }
        });
    });

    function addQuestion(context) {
        console.log("add question");
        $('#save-question').attr('method', 'edit');
        $('#save-question').data('question-id', context.data('question-id'));
        showAddQuestionModal(context, context.find('.question-number').text());
        $('#question-title').val(context.find('.question-title').text());
        $('#question-type-select option[value=' +context.data('question-type') +']').prop('selected', true);
        toggleAnswerChoices();
    }

    /**************************************************************************************************************
     *                                     END PAGE MANIPULATION                                                  *
     *************************************************************************************************************/

});

function init() {
    loadingToast('Loading Survey');
    //variable initialization
    choiceCount = 2;
    pageCount = 1;

    //  !!!IMPORTANT!!
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //run required functions
    toggleAnswerChoices();

    $('.dataTable').DataTable();

    $('[data-toggle="tooltip"]').tooltip()

    $(".question-row-container").each(function(){
        $(this).height($(this).find('.height-adjuster').height());
    });

    $('.btn').click(function (e) {
        e.stopPropagation();
    });

    //HIDE LOADING TOAST
    closeToast();
}

function toggleAnswerChoices() {
    selectedChoiceType = $('#question-type-select').find('option:selected', this);
    if(selectedChoiceType.attr('has-choices')==1){
        $('#choice-container').collapse('show');
    }else{
        $('#choice-container').collapse('hide');
    }
}



/**************************************************************************************************************
 *                                          HELPER FUNCTIONS                                                  *
 *************************************************************************************************************/

function getPage(id){
    return $('#pageid' +id);
}

/**************************************************************************************************************
 *                                        END HELPER FUNCTIONS                                                *
 *************************************************************************************************************/

/**************************************************************************************************************
 *                                                MISCS                                                       *
 *************************************************************************************************************/

function loadingToast(heading){
    $.toast({
        heading: heading,
        hideAfter: false,
        showHideTransition: 'slide',
        icon: 'success'
    });
}

function errorToast(message){
    $.toast({
        heading: 'Oooops! Something Went Wrong!',
        icon: 'error',
        stack: false
    })
}

function successToast(message){
    $.toast({
        heading: 'Success!',
        text: message,
        icon: 'success',
        stack: false
    })
}

function closeToast(){
    $('.jq-toast-wrap').remove();
}

/**************************************************************************************************************
 *                                       PAGE FUNCTIONS                                                       *
 *************************************************************************************************************/

function validateInputs(){
    var ok = true;
    $('input').each(function(){
        if($(this).prop("required")){
            if($.trim($(this).val())==""){
                $(this).parent().addClass("has-error");
                ok = false;
            }else{
                $(this).parent().removeClass("has-error");
            }
        }
    });
    if(!ok){
        bootbox.alert("Please Fill up All Required Fields");
    }
    return ok;
}

function updateQuestionNumbers(){
    questionNo = 1;
    $('.page-row').each(function(){
        $(this).find('.question-number').each(function(){
            $(this).data('question-number', questionNo);
            $(this).html(questionNo++);
        });
        $(this).find('.add-question').data('question-number', questionNo);
    });

}

function updatePageNumbers(){
    pageNo = 1;
    $('.page-row').each(function () {
        $(this).data('page-number', pageNo);
        $(this).find('.page-no').html('Page' +pageNo++);
    });
}

function showAddQuestionModal(target, questionNo){
    $('#selected-page-id').val(target.closest('.page-row').data('id'));
    $('#modal-question-number').html('Q' +questionNo +':');
}

/**************************************************************************************************************
 *                                    END PAGE FUNCTIONS                                                      *
 *************************************************************************************************************/