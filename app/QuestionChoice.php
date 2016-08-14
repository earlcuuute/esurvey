<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionChoice extends Model
{
    protected $fillable = [
        'label',
    ];

    public function question(){
        return $this->belongsTo(Question::class);
    }
}
