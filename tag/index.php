<?
	include(getenv('DOCUMENT_ROOT') . '/admin/inc/header.php');
	require_once(getenv('DOCUMENT_ROOT') . '/admin/lib/App.class.php');
	$app = App::getInstance();

	$arAllMedia = array();

	if (!empty($_GET['TAGS']))
	{
		$arParams = array(
			// 'COUNT' => 10,
			// 'MIN_TAG_ID' => '',
			// 'MAX_TAG_ID' => '',
		);
		$arAllMedia = $app->getMediaByTags($_GET['TAGS'], $arParams);
	}

	if (!empty($arAllMedia))
	{
		include(getenv('DOCUMENT_ROOT') . '/admin/inc/items.php');
	}

	include(getenv('DOCUMENT_ROOT') . '/admin/inc/footer.php');
?>