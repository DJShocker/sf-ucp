<?php

use Carbon\Carbon;
class EmailController extends BaseController {

	public function process()
	{
		// validation
		if ( ! Input::has('t') || ! Input::has('s') || ! Input::has('m') || ! Input::has('n') )
       		return Response::json(array('error' => "Invalid parameters"));

		$to = Input::get('t');
		$name = Input::get('n');
		$subject = Input::get('s');
		$content = Input::get('m');

		Mail::send('emails.basic', array('content' => $content), function($message) use ($to, $name, $subject)
		{
		    $message->to($to, $name)->subject($subject);
		});
	}

	public function verify($userid, $verifyid)
	{
		$user = User::findOrFail($userid);

		$verification = DB::table('EMAIL_VERIFY')->where('USER_ID', '=', $user->ID)->where('ID', '=', $verifyid)->first();

		if ( ! is_null($verification))
		{
			// insert into verified emails
			DB::table('EMAILS')->insert([
				'USER_ID' => $verification->USER_ID,
				'EMAIL' => $verification->EMAIL,
				'MODE' => 2,
				'LAST_CHANGED' => time()
			]);

			// insert into mailchimp
			self::mailchimpSubscribe($verification->EMAIL, $user->NAME);

			// delete verification shit
			DB::table('EMAIL_VERIFY')->where('ID', '=', $verification->ID)->delete();
			return "Thanks {$user->NAME} for verifying your email ({$verification->EMAIL})!";
		}
		else
		{
			return "An invalid verification id has been supplied for this user (maybe verified?)";
		}
	}

	public function mailchimpSubscribe($email, $username)
	{
		$postData = [
			'email_address' => $email,
			'status' => 'subscribed',
			'merge_fields' => [
				'FNAME' => $username
			]
		];

		$ch = curl_init('https://us12.api.mailchimp.com/3.0/lists/6c15de6a53/members/');

		curl_setopt_array($ch, array(
		    CURLOPT_POST => TRUE,
		    CURLOPT_RETURNTRANSFER => TRUE,
		    CURLOPT_HTTPHEADER => ['Authorization: apikey 83e4e8c473230da2abbb755074ae6d50-us12', 'Content-Type: application/json'],
		    CURLOPT_POSTFIELDS => json_encode($postData)
		));

		curl_exec($ch);
		curl_close($ch);
	}

}
