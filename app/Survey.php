<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $fillable = [
        'survey_title', 'survey_id', 'updated_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(SurveyCategory::class);
    }

    public function pages(){
        return $this->hasMany(SurveyPage::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
