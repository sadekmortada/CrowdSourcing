<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = [
        'title', 'body', 'score','workshop_id','user_id' , 'takenAsProject'
    ];

    public function workshops(){
        return $this->hasMany(Workshop::class);
    }

    public function voting(){
        return $this->hasOne(Voting::class);
    }
    public function members(){
        return $this->belongsToMany('App\User','projects');
    }
}
