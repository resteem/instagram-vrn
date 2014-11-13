<?
	include_once('db/locations.php');
	require_once('lib/App.class.php');
	$app = App::getInstance();
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
			<img src="/images/logo.png" title="Воронеж в Инстаграме">
		</div>
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
endif;
?>
