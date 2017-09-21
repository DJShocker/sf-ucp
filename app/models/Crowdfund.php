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
    	if ( ! $this->RELEASE_DATE) {
    		return "to be announced";
    	} else {
	    	$releaseDate = new Carbon($this->RELEASE_DATE);
	    	return $releaseDate->diffForHumans();
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
