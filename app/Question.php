<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_title', 'order_no', 'survey_page_id', 'question_type_id',
    ];

    public function surveyPage(){
        return $this->belongsTo(SurveyPage::class);
    }

    public function questionType(){
        return $this->belongsTo(QuestionType::class);
    }

    public function choices(){
        return $this->hasMany(QuestionChoice::class);
    }
}
