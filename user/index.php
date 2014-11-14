<?
	include(getenv('DOCUMENT_ROOT') . '/admin/inc/header.php');
	require_once(getenv('DOCUMENT_ROOT') . '/admin/lib/App.class.php');
	$app = App::getInstance();

	$now = time();
	$arAllMedia = array();

	if (!empty($_GET['LOGIN']))
	{
		// not working, always returns 0
		$user_id = $app->getUserIdByLogin($_GET['LOGIN']);
	}
	else
	{
		$user_id = $_GET['ID'];
	}

	if (!empty($user_id))
	{
		$arParams = array(
			// 'COUNT' => 10,
			// 'MIN_ID' => '',
			// 'MAX_ID' => '',
			// 'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
			// 'MAX_TIMESTAMP' => $now,
		);
		$arAllMedia = $app->getMediaByUserId($_GET['ID'], $arParams);
	}

	if (!empty($arAllMedia))
	{
		include(getenv('DOCUMENT_ROOT') . '/admin/inc/items.php');
	}

	include(getenv('DOCUMENT_ROOT') . '/admin/inc/footer.php');
?>