<?
	include_once('_/auth_configs.php');
	// include_once('_/analyticstracking.php');
	include_once('lib/functions.php');

	if (isAuthorized())
	{
		redirect('/'); exit;
	}
	if (isDevMode())
	{
		setcookie('INSTAGRAM_ACCESS_TOKEN', DEV_ACCESS_TOKEN);
		setcookie('INSTAGRAM_USER_NAME', DEV_USER_NAME);
		setcookie('INSTAGRAM_USER_PIC', DEV_USER_PIC);
		setcookie('INSTAGRAM_USER_ID', DEV_USER_ID);
		redirect('/'); exit;
	}

	if (!isset($_GET['code']) && !isset($_GET['error']))
	{
		// Step One: Direct my user to Instagram's authorization URL
		$urlAuth = 'https://api.instagram.com/oauth/authorize/?client_id=' . INSTAGRAM_CLIENT_ID . '&redirect_uri=' . INSTAGRAM_REDIRECT_URI . '&response_type=code';
		redirect($urlAuth); exit;
	}
	else
	{
		// Step Two: Receive the redirect from Instagram
		if (isset($_GET['error']))
		{
			showArray($_GET['error_description']);
		}
		else
		{
			// Step Three: Request the access_token
			$url = 'https://api.instagram.com/oauth/access_token';
			$data = array(
				'grant_type' => 'authorization_code',
				'client_id' => INSTAGRAM_CLIENT_ID,
				'client_secret' => INSTAGRAM_CLIENT_SECRET,
				'redirect_uri' => INSTAGRAM_REDIRECT_URI,
				'code' => $_GET['code']
			);
			$data = http_build_query($data);
			$arParams = array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Accept: application/json',
					'content' => $data
				)
			);
			$ctx = stream_context_create($arParams);
			$fp = fopen($url, 'rb', FALSE, $ctx);
			$response = stream_get_contents($fp);
			$response = json_decode($response);

			setcookie('INSTAGRAM_ACCESS_TOKEN', $response->access_token);
			setcookie('INSTAGRAM_USER_NAME', $response->user->username);
			setcookie('INSTAGRAM_USER_PIC', $response->user->profile_picture);
			setcookie('INSTAGRAM_USER_ID', $response->user->id);
			redirect('/'); exit;
		}
	}
?>