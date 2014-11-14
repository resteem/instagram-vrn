<?
	require_once(getenv('DOCUMENT_ROOT') . '/admin/lib/App.class.php');
	$app = App::getInstance();

	if ($app->isAuthorized())
	{
		App::redirect('/'); exit;
	}


	if ($app->isDevMode())
	{
		$app->setAccessToken(DEV_ACCESS_TOKEN);
		$app->setUsername(DEV_USER_NAME);
		$app->setProfilePicture(DEV_USER_PIC);
		$app->setUserId(DEV_USER_ID);

		App::redirect('/'); exit;
	}

	if (!isset($_GET['code']) && !isset($_GET['error']))
	{
		// Step One: Direct my user to Instagram's authorization URL
		App::redirect($app->getAuthUrl()); exit;
	}
	else
	{
		// Step Two: Receive the redirect from Instagram
		if (isset($_GET['error']))
		{
			App::showArray($_GET['error_description']);
		}
		else
		{
			// Step Three: Request the access_token
			$response = $app->getAuthToken($_GET['code']);

			$app->setAccessToken($response->access_token);
			$app->setUsername($response->user->username);
			$app->setProfilePicture($response->user->profile_picture);
			$app->setUserId($response->user->id);

			App::redirect('/'); exit;
		}
	}