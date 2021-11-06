<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['question_id','answer_content','answer_true'];
    protected $primaryKey = 'answer_id';
    protected $table = 'answers';
    
    public function questions(){
        return $this->belongsTo('App\Models\Question','question_id');
    }

}
