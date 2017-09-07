<?php

use \Carbon\Carbon;

class CrowdfundPatreon extends Eloquent{

    protected $table = 'CROWDFUND_PATREONS';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('User', 'USER_ID');
    }

    public function crowdfund()
    {
        return $this->belongsTo('Crowdfund', 'CROWDFUND_ID');
    }

    public function time()
    {
        $time = new Carbon($this->DATE);
        return $time->diffForHumans();
    }

}

