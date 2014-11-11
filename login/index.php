<?
	require_once(getenv('DOCUMENT_ROOT') . '/lib/functions.php');

	if (isAuthorized())
	{
		redirect('/'); exit;
	}

	$instagram = getInstagramInstance();

	if (isDevMode())
	{
		$instagram->setAccessToken(DEV_ACCESS_TOKEN);
		$instagram->setUsername(DEV_USER_NAME);
		$instagram->setProfilePicture(DEV_USER_PIC);
		$instagram->setUserId(DEV_USER_ID);
		setInstagramInstance($instagram);

		redirect('/'); exit;
	}

	if (!isset($_GET['code']) && !isset($_GET['error']))
	{
		// Step One: Direct my user to Instagram's authorization URL
		redirect($instagram->getAuthUrl()); exit;
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
			$response = $instagram->getAuthToken($_GET['code']);

			$instagram->setAccessToken($response->access_token);
			$instagram->setUsername($response->user->username);
			$instagram->setProfilePicture($response->user->profile_picture);
			$instagram->setUserId($response->user->id);
			setInstagramInstance($instagram);

			redirect('/'); exit;
		}
	}