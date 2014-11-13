<?
	include('inc/header.php');
	require_once('lib/App.class.php');
	$app = App::getInstance();

	include_once('db/locations.php');
	if ($app->isAuthorized())
	{
		$now = time();
		$arParams = array(
			'DISTANCE' => ($arLocations['DISTANCE'] ? $arLocations['DISTANCE'] : App::DEFAULT_DISTANCE),
			'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
			'MAX_TIMESTAMP' => $now,
		);
		$arAllMedia = $app->getMediaByLocationPoints($arLocations, $arParams);
		include('inc/items.php');
	}

	include('inc/footer.php');
?>