<!DOCTYPE html>
<html lang="ru">
<head prefix="og: http://ogp.me/ns#">
	<meta charset="utf-8">
	<title>Воронеж в Инстаграме</title>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="script/script.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">
</head>
<body>
<?
	include_once('_/analyticstracking.php');
	include_once('_/auth_configs.php');
	include_once('lib/functions.php');
?>
<header>
	<div class="left">
		<div class="logo left" title="Воронеж в Инстаграме"></div>
		<div class="header left">
			<h1>Воронеж в Инстаграме</h1>
			<h2>Что сегодня фотографируют в Воронеже</h2>
		</div>
	</div>
	<div class="right"><?
		if (isAuthorized()):
			?>
			<div class="user">
				<div class="userpic left" title="<?=$_COOKIE['INSTAGRAM_USER_NAME'];?>">
					<img src="<?=$_COOKIE['INSTAGRAM_USER_PIC'];?>">
				</div>
				<div class="username left"><?=$_COOKIE['INSTAGRAM_USER_NAME'];?></div>
			</div>
			<?
		endif;
	?></div>
	<div class="clear"></div>
</header>
<?if (!isAuthorized()):?>
	Для просмотра фотографий требуется <a class="uline" href="/login">войти</a> через Instagram.
	<br>
	<br>
<?else:?>
<?
	include_once('lib/city_russia_36.php');
	$now = time();
	$arParams = array(
		'DISTANCE' => '5000',
		'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
		'MAX_TIMESTAMP' => $now,
		'INSTAGRAM_ACCESS_TOKEN' => $_COOKIE['INSTAGRAM_ACCESS_TOKEN'],
	);
	$tplUrlLocationCircle = getTplUrlLocation($arParams);

	$arPhotos = getLocationPhotos($arCityRussia36, $tplUrlLocationCircle);
?>
	<div class="items"><?
		foreach ($arPhotos as $arPhoto):
		?><div class="item left">
			<div class="info">
				<div class="author left">
					<div class="left">
						<a href="<?=$arPhoto['USER']['PROFILE_URL'];?>" title="<?=$arPhoto['USER']['FULL_NAME'];?>">
							<img src="<?=$arPhoto['USER']['PROFILE_PICTURE'];?>" alt="<?=$arPhoto['USER']['USERNAME'];?>">
						</a>
					</div>
					<div class="left">
						<a class="uline" href="<?=$arPhoto['USER']['PROFILE_URL'];?>" title="<?=($arPhoto['USER']['FULL_NAME'] ? $arPhoto['USER']['FULL_NAME'] : $arPhoto['USER']['USERNAME']);?>">
							<?=$arPhoto['USER']['USERNAME'];?>
						</a>
						<div class="location">
							<div class="location_a_wrapper">
								<a class="uline" href="<?=$arPhoto['LOCATION']['LINK'];?>" title="<?=$arPhoto['LOCATION']['NAME'];?>">
									<?=$arPhoto['LOCATION']['NAME'];?>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="time right" title="<?=date('d.m.Y H:i:s', $arPhoto['MEDIA']['CREATED_TIME']);?>">
						<?=date('H:i', $arPhoto['MEDIA']['CREATED_TIME']);?>
					</div>
					<div class="clear"></div>
					<div class="stats right">
						<div class="comments right"><?=$arPhoto['MEDIA']['COMMENTS_COUNT']?></div>
						<div class="likes right"><?=$arPhoto['MEDIA']['LIKES_COUNT']?></div>
					</div>
				</div>
			</div>
			<div class="photo">
				<a href="<?=$arPhoto['MEDIA']['LINK'];?>" title="<?=$arPhoto['MEDIA']['CAPTION'];?>">
					<img src="<?=$arPhoto['MEDIA']['URL_LOW']?>">
				</a>
			</div>
		</div><?
		endforeach;
	?>
	<div class="clear"></div>
	</div>
<?endif;?>
<footer>
	© 2014
</footer>
</body>
</html>