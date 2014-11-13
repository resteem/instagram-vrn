<?
	include_once('db/locations.php');
	require_once('lib/App.class.php');
	$app = App::getInstance();
?><!DOCTYPE html>
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
		<div class="logo" title="Воронеж в Инстаграме"></div>
		<div class="header">
			<h1>Воронеж в Инстаграме</h1>
			<h2>Что сегодня фотографируют в Воронеже</h2>
		</div>
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
else: // if (!$app->isAuthorized()):
	$now = time();
	$arParams = array(
		'DISTANCE' => ($arLocations['DISTANCE'] ? $arLocations['DISTANCE'] : App::DEFAULT_DISTANCE),
		'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
		'MAX_TIMESTAMP' => $now,
	);
	$arAllMedia = $app->getMediaByLocationPoints($arLocations, $arParams);
	include('inc/items.php');
endif; // if (!$app->isAuthorized()):
?><footer>
	© 2014
</footer>
</body>
</html>