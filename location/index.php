<?
	include(getenv('DOCUMENT_ROOT') . '/inc/header.php');
	require_once(getenv('DOCUMENT_ROOT') . '/lib/App.class.php');
	$app = App::getInstance();

	if (!empty($_GET['LAT']) && !empty($_GET['LNG']))
	{
		$now = time();
		$arParams = array(
			'DISTANCE' => '1',
			// 'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
			// 'MAX_TIMESTAMP' => $now,
		);
		$arAllMedia = $app->getMediaByLocationPoint(array('LAT' => $_GET['LAT'], 'LNG' => $_GET['LNG']), $arParams);
		include(getenv('DOCUMENT_ROOT') . '/inc/items.php');
	}

	include(getenv('DOCUMENT_ROOT') . '/inc/footer.php');
?>