<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role' , 'confirmed','auto_confirm','can_vote','can_submit',
    ];

    // protected $guarded = [] ;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function workshops(){
        return $this->hasMany(Workshop::class);
    }
    public function pWorkshops(){
        return $this->belongsToMany('App\Workshop','cards'); //many to many
    }
    
    public function votings(){
            return $this->belongsToMany('App\Cards','votings');
    }

    
    public function isAdmin(){
        return $this->role == 0;
    }

    public function isMonitor(){
        return $this->role == 1;
    }

    public function isParticipant(){
        return $this->role == 2;
    }
    
}
