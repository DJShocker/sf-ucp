<?php namespace Gliee\Irresistible;

class Utils
{
	public function __construct()
	{
		// construct
	}

	public static function humanNumberFormat($number, $precision = 1)
	{
		if($number > 1000000)
			return round($number / 1000000, $precision) . "M";

		if($number > 10000)
			return round($number / 1000, $precision) . "K";

		return round($number, $precision);
	}

	public static function adminlevelToString($rank)
	{
		switch($rank)
		{
			case 6:	$string = '<font color="#800000"><strong>Executive Administrator</strong></font>';	break;
			case 5:	$string = '<font color="#FF0000"><strong>Head Administrator</strong></font>';		break;
			case 4: $string = '<font color="#FF0099"><strong>Lead Administrator</strong></font>';		break;
			case 3:	$string = '<font color="#3333FF"><strong>Senior Administrator</strong></font>';		break;
			case 2:	$string = '<font color="#9900FF"><strong>General Administrator</strong></font>';	break;
			case 1:	$string = '<font color="#C26100"><strong>Trial Administrator</strong></font>';		break;
			default: $string = 'None';
		}
		return $string;
	}

	public static function vipToString($vip)
	{
		switch($vip)
		{
            case 1:  $string = "Regular"; 	break;
            case 2:  $string = "Bronze"; 	break;
            case 3:  $string = "Gold"; 		break;
            case 4:  $string = "Platinum"; 	break;
            case 5:  $string = "Diamond";	break;
            default: $string = "n/a"; 		break;
		}
		return $string;
	}

	public static function skillToString($skill)
	{
		switch($skill)
		{
			case 0: $string = "Rapist"; 		break;
			case 1: $string = "Kidnapper"; 		break;
			case 2: $string = "Terrorist";		break;
			case 3: $string = "Hitman";			break;
			case 4: $string = "Prostitute";		break;
			case 5: $string = "Weapon Dealer";	break;
			case 6: $string = "Drug Dealer";	break;
			case 7: $string = "Dirty Mechanic";	break;
			case 8: $string = "Burglar";		break;
		}
		return $string;
	}

	public static function helpTopicColor($category)
	{
		switch($category)
		{
			case 0: $string = '<span class="label label-server">Server</span>'; break;
			case 1: $string = '<span class="label label-help">Help</span>'; 	break;
			case 2: $string = '<span class="label label-faq">FAQ</span>';		break;
			case 3: $string = '<span class="label label-guide">GUIDE</span>';	break;
			case 4: $string = '<span class="label label-tips">TIPS</span>';		break;
			default: $string = "info";
		}
		return $string;
	}

	public static function secondstohuman($secs)
	{
	    $units = array(
            "months" 		=> 4*7*24*3600,
            "weeks" 		=>   7*24*3600,
            "days" 			=>     24*3600,
            "hours" 		=>        3600,
            "minutes" 		=>          60,
            "seconds" 		=>           1,
	    );

	    if($secs < 60) return "Less than a minute!";

	    $s = "";

	    foreach ( $units as $name => $divisor ) {
	        if ( $quot = intval($secs / $divisor) ) {
                $s .= "$quot $name";
                $s .= ", ";
                $secs -= $quot * $divisor;
	        }
	    }
	    return substr($s, 0, -2);
	}
}
