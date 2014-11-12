<?
	require_once(getenv('DOCUMENT_ROOT') . '/lib/App.class.php');
	$app = App::getInstance();
	$app->logout();

	App::redirect('/');
?>