<?
	require_once('/_/auth_configs.php');
	require_once('/lib/Instagram.class.php');

	if (!function_exists('showArray'))
	{
		function showArray($value)
		{
			echo '<pre>', print_r($value, TRUE), '</pre>';
		}
	} // showArray

	if (!function_exists('redirect'))
	{
		function redirect($URL)
		{
			header('Location: ' . $URL);
		}
	} // redirect

	if (!function_exists('isDevMode'))
	{
		function isDevMode()
		{
			return (strpos($_SERVER['HTTP_HOST'], 'localhost') === 0);
		}
	} // isDevMode

	if (!function_exists('getInstagramInstance'))
	{
		function getInstagramInstance()
		{
			if ($_COOKIE['INSTAGRAM_INSTANCE'])
			{
				$instagram = unserialize($_COOKIE['INSTAGRAM_INSTANCE']);
			}
			else
			{
				$arInstaParams = array(
					'CLIENT_ID' => INSTAGRAM_CLIENT_ID,
					'CLIENT_SECRET' => INSTAGRAM_CLIENT_SECRET,
					'REDIRECT_URI' => INSTAGRAM_REDIRECT_URI,
				);
				$instagram = new Instagram($arInstaParams);
				setcookie('INSTAGRAM_INSTANCE', serialize($instagram));
			}
			return $instagram;
		}
	} // getInstagramInstance

	if (!function_exists('isAuthorized'))
	{
		function isAuthorized()
		{
			$instagram = getInstagramInstance();
			$token = $instagram->getAccessToken();
			return $token;
		}
	} // isAuthorized

	if (!function_exists('getArPhotoFromInsta'))
	{
		function getArMediaFromInsta($oInstaMedia)
		{
			$arMedia = array(
				'MEDIA' => array(
					'ID' => $oInstaMedia->id,
					'TYPE' => $oInstaMedia->type,
					'FILTER' => $oInstaMedia->filter,
					'CREATED_TIME' => $oInstaMedia->created_time,
					'LINK' => $oInstaMedia->link,
					'URL' => $oInstaMedia->images->standard_resolution->url,
					'URL_LOW' => $oInstaMedia->images->low_resolution->url,
					'URL_THUMBNAIL' => $oInstaMedia->images->thumbnail->url,
					'CAPTION' => $oInstaMedia->caption->text,
					'LIKES_COUNT' => $oInstaMedia->likes->count,
					'COMMENTS_COUNT' => $oInstaMedia->comments->count,
				),
				'LOCATION' => array(
					'NAME' => ($oInstaMedia->location->name ? $oInstaMedia->location->name : $oInstaMedia->location->latitude . ', ' . $oInstaMedia->location->longitude),
					'ID' => $oInstaMedia->location->id,
					'LATITUDE' => $oInstaMedia->location->latitude,
					'LONGITUDE' => $oInstaMedia->location->longitude,
					'LINK' => 'https://www.google.ru/maps?q=' . $oInstaMedia->location->latitude . ',' . $oInstaMedia->location->longitude,
				),
				'USER' => array(
					'ID' => $oInstaMedia->user->id,
					'USERNAME' => $oInstaMedia->user->username,
					'PROFILE_PICTURE' => $oInstaMedia->user->profile_picture,
					'PROFILE_URL' => 'http://instagram.com/' . $oInstaMedia->user->username,
					'FULL_NAME' => $oInstaMedia->user->full_name,
				),
			);
			return $arMedia;
		}
	} // getArPhotoFromInsta