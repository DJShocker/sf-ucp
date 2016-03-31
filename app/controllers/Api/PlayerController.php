<?php namespace API;

use \Illuminate\Routing\Controller;
use \Dingo\Api\Routing\ControllerTrait;

class PlayerController extends \Controller {

    use ControllerTrait;

    public function __construct() {
    	// Constructor
    }

    public function record($apiKey)
    {
        if($apiKey != \Config::get('irresistible.api_key')){
            return \App::abort('403');
    	}

        try
        {
        	\DB::statement('UPDATE `USERS` SET `WEEKEND_UPTIME` = `UPTIME`');

        	return "Users' weekly time has been updated.";
        }
        catch(Exception $e)
        {
        	return \App::abort('500');
        }
    }

    public function article($id)
    {
        if(ctype_digit($id) == false)
            return \App::abort(403);

        $contentData = \DB::table('HELP')->find($id);

        if(is_null($contentData))
            return \App::abort(404);

        $content = str_replace("<li>", "<li>* ", $contentData->CONTENT);

        return "{FFFFFF}" . html_entity_decode(strip_tags($content), ENT_QUOTES, 'UTF-8');
    }

    public function data($id, $name)
    {
        if (!ctype_digit($id) && !ctype_alnum($name)) {
            return $this->response->error('The specified user has not been found.', 404);
        }

        $userData = \User::where('ID', '=', $id)->where('NAME', '=', $name)->first();

        if (is_null($userData)) {
            return $this->response->error('The specified user has not been found.', 404);
        }

        return [
            'username' => (string)$userData->NAME,
            'kills' => (int)$userData->KILLS,
            'deaths' => (int)$userData->DEATHS,
            'ratio' => (float)sprintf("%4.2f",$userData->KILLS/$userData->DEATHS),
            'admin' => (int)$userData->ADMIN_LEVEL,
            'vip' => (string)\Gliee\Irresistible\Utils::vipToString($userData->VIP_PACKAGE),
            'score' => (int)$userData->SCORE,
            'last_logged' => (string)\Carbon\Carbon::createFromTimeStamp($userData->LASTLOGGED)->diffForHumans(),
            'robberies' => (int)$userData->ROBBERIES,
            'arrests' => (int)$userData->ARRESTS
        ];
    }
}
