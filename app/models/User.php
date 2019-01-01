<?php

class User extends Eloquent{

    protected $table = 'USERS';

    protected $hidden = array('PASSWORD');

    protected $fillable = [];

    public $timestamps = false;

    public $key = 'ID';
    protected $primaryKey = 'ID';

    /**
     * Find username if exists return salt
     */
    public function scopeUsername($query, $username)
    {
        $username = trim(strip_tags($username));
        return $query->where('NAME', '=', $username);
    }

    public function adminlog() {
        return $this->hasMany('AdminLog', 'USER_ID')->orderBy('DATE', 'desc');
    }

    public function gang() {
        return $this->belongsTo('Gang', 'GANG_ID', 'ID');
    }

    public function xp() {
        return DB::table('USER_LEVELS')->where('USER_ID', $this->ID)->sum('EXPERIENCE');
    }
}
