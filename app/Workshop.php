<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
   protected $fillable = [
      'title', 'body', 'workshop_key', 'user_id' , 'participants','participated','voted','locked','stage'
  ];
  
   public function users(){
      return $this->belongsToMany('App\User','cards'); //many to many
  }

  public function user(){
     return $this->belongsTo('App\User');
  }
  public function projects(){
   return $this->hasMany('App\Project');
}

   // public function cards(){
   //    return $this->belongsToMany('App\cards','votings');
   // }
}
