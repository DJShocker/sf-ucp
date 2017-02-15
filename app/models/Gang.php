<?php

class Gang extends Eloquent{

    protected $table = 'GANGS';

    public $timestamps = false;

    public function leader() {
        return $this->belongsTo('User', 'LEADER', 'ID');
    }

    public function members() {
        return $this->hasMany('User', 'GANG_ID', 'ID');
    }

    public function color() {
    	return substr("00000000".dechex($this->COLOR),-8, -2);
    }

    public function url() {
        $name = e(preg_replace('/^-+|-+$/', '', strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', $this->NAME))));
        return URL::route('gangs.show', [$this->ID, $name]);
    }

    public function is_leader(User $user) {
        if ($this->LEADER == $user->ID)
            return true;

        $coleader = GangColeader::where('GANG_ID', '=', $this->ID)->where('USER_ID', '=', $user->ID)->first();
        return ! is_null($coleader);
    }
}
