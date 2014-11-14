<?
	include('admin/inc/header.php');
	require_once('admin/lib/App.class.php');
	$app = App::getInstance();

	include_once('admin/db/locations.php');
	if ($app->isAuthorized())
	{
		$now = time();
		$arParams = array(
			'DISTANCE' => ($arLocations['DISTANCE'] ? $arLocations['DISTANCE'] : App::DEFAULT_DISTANCE),
			'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
			'MAX_TIMESTAMP' => $now,
		);
		$arAllMedia = $app->getMediaByLocationPoints($arLocations, $arParams);
		include('admin/inc/items.php');
	}

	include('admin/inc/footer.php');
?>