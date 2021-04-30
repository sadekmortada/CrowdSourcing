<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    protected $fillable = [
        'workshop_id','user_id','card_id'
    ];
    public function cards(){
        return $this->hasMany(Card::class);
    }
}
