<?
	session_start();
	
	if(!isset($cookie_id))
	{
		// no unique cookie value is set - set one
		$cookie_id = time() + rand(10000,99999);
		setcookie("cookie_id", $cookie_id, time()+3600*24*1000, "/");
	}

	if(!session_is_registered('sess'))
	{
		$sess = Array();
		session_register('sess');

		// session has just been started
		$user = new GuestUser($cookie_id);

		// new session
	}
	else
	{
		if($sess['authenticated'])
		{
			// user is logged in
			$user = new AuthUser($sess['email'], $sess['uid']);
		}
		else
		{
			// user is not logged in
			$user = new GuestUser($cookie_id, $sess['uid']);
		}
	}
?>