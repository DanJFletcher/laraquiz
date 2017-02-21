<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    /**
     * Fillables
     *
     * @var Array
     */
    protected $fillable = ['answer', 'text', 'quiz_id'];

    /**
     * Get the quiz that owns the question
     */
     public function quiz()
     {
         return $this->belongsTo('App\Quiz');
     }

     /**
      * Get the options that belong to the question
      */
      public function options()
      {
          return $this->hasMany('App\Option');
      }
}
