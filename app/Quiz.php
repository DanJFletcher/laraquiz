<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['user_id', 'title'];

    /**
     * Get the user that owns the quiz 
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Get the questions that belong to the quiz
     */
     public function questions()
     {
         return $this->hasMany('App\Question');
     }
}
