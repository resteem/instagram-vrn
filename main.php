<?
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
		'DISTANCE' => '5000',
		'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
		'MAX_TIMESTAMP' => $now,
	);
	include_once('db/city_russia_36.php');
	$arAllMedia = $app->getMediaByLocationPoints($arCityRussia36, $arParams);
?>
	<div class="items"><?
		foreach ($arAllMedia as $arMedia):
		?><div class="item">
			<div class="info">
				<div class="author">
					<div class="left">
						<a href="<?=$arMedia['USER']['PROFILE_URL'];?>" title="<?=$arMedia['USER']['FULL_NAME'];?>">
							<img src="<?=$arMedia['USER']['PROFILE_PICTURE'];?>" alt="<?=$arMedia['USER']['USERNAME'];?>">
						</a>
					</div>
					<div class="left">
						<a class="uline" href="<?=$arMedia['USER']['PROFILE_URL'];?>" title="<?=($arMedia['USER']['FULL_NAME'] ? $arMedia['USER']['FULL_NAME'] : $arMedia['USER']['USERNAME']);?>">
							<?=$arMedia['USER']['USERNAME'];?>
						</a>
						<div class="location">
							<div class="location_a_wrapper">
								<a class="uline" href="<?=$arMedia['LOCATION']['LINK'];?>" title="<?=$arMedia['LOCATION']['NAME'];?>">
									<?=$arMedia['LOCATION']['NAME'];?>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="time" title="<?=date('d.m.Y H:i:s', $arMedia['MEDIA']['CREATED_TIME']);?>">
						<?=date('H:i', $arMedia['MEDIA']['CREATED_TIME']);?>
					</div>
					<div class="clear"></div>
					<div class="stats">
						<div class="comments"><?=$arMedia['MEDIA']['COMMENTS_COUNT']?></div>
						<div class="likes"><?=$arMedia['MEDIA']['LIKES_COUNT']?></div>
					</div>
				</div>
			</div>
			<div class="media">
				<a href="<?=$arMedia['MEDIA']['LINK'];?>" title="<?=$arMedia['MEDIA']['CAPTION'];?>">
					<img src="<?=$arMedia['MEDIA']['URL_LOW']?>">
				</a>
			</div>
		</div><?
		endforeach;
	?>
	<div class="clear"></div>
	</div><?
endif; // if (!$app->isAuthorized()):
?><footer>
	© 2014
</footer>
</body>
</html>