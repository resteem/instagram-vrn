<?
	require_once(getenv('DOCUMENT_ROOT') . '/admin/db/locations.php');
	require_once(getenv('DOCUMENT_ROOT') . '/admin/lib/App.class.php');
	$app = App::getInstance();

	$isLocationPage = (!empty($_GET['LAT']) && !empty($_GET['LNG']));
	// $isLocationPage = FALSE;
	$isUserPage = FALSE;
	// $isUserPage = (!empty($_GET['USER']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="utf-8">
	<title>Воронеж в Инстаграме</title>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="script/script.js"></script>
<?
		include_once('_/analyticstracking.php');
?>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<header>
	<div class="left">
		<div class="logo">
			<?
			// style="border-radius: 7px;"
			?>
			<a href="/"><?
				if ($isLocationPage):
					?><img src="/images/logo.png" title="Воронеж в Инстаграме"><?
				else:
					?><img src="/images/logo.png" title="Воронеж в Инстаграме"><?
				endif;
			?></a>
		</div>
		<div class="header">
			<h1>Воронеж в Инстаграме</h1><?
			if ($isLocationPage):
				?><h2><?=$_GET['LAT'];?>, <?=$_GET['LNG'];?></h2><?
			else:
				?><h2>Что сегодня фотографируют в Воронеже</h2><?
			endif;
		?></div>
	</div>
	<div class="right"><?
		if ($app->isAuthorized()):
			?>
			<div class="user">
				<div class="userpic" title="<?=$app->getUsername();?>">
					<img src="<?=$app->getProfilePicture();?>">
				</div>
				<div class="logout"><a class="uline" href="/logout">Выйти</a></div>
			</div>
			<?
		endif;
	?></div>
	<div class="clear"></div>
</header><?
if (!$app->isAuthorized()):
	?><br>Для просмотра фотографий требуется <a class="uline" href="/login">войти через Instagram</a>.<br><br><?
endif;
?>
