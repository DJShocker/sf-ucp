<?php

use \Carbon\Carbon;

class Crowdfund extends Eloquent{

    protected $table = 'CROWDFUNDS';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    public function endsIn()
    {
    	$endDate = new Carbon($this->END_DATE);

    	return $endDate->diffInDays();
    }

    public function releaseIn()
    {
        $releaseDate = new Carbon($this->RELEASE_DATE);
        if ($releaseDate == Carbon::parse('0000-00-00 00:00:00')) {
    		return "to be announced";
    	} else {
	    	return $releaseDate->diffForHumans();
    	}
    }

    public function isReleased()
    {
        $endDate = new Carbon($this->RELEASE_DATE);
        if ($endDate == Carbon::parse('0000-00-00 00:00:00')) {
            return false;
        } else {
            return $endDate->isPast();
        }
    }

    public function isEnded()
    {
    	$endDate = new Carbon($this->END_DATE);

    	return $endDate->isPast();
    }

    public function packages()
    {
    	return $this->hasMany('CrowdfundPack', 'CROWDFUND_ID')->orderBy('REQUIRED_AMOUNT', 'desc');
    }

    public function patreons()
    {
    	return $this->hasMany('CrowdfundPatreon', 'CROWDFUND_ID');
    }

    public function amountRaised()
    {
    	return $this->patreons->sum('AMOUNT');
    }

    public function pledgePercentage()
    {
    	return ($this->amountRaised() / $this->FUND_TARGET) * 100.0;
    }
}
