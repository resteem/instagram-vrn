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
	require_once('/lib/functions.php');
	include_once('/_/analyticstracking.php');
	$instagram = getInstagramInstance();
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
				<div class="userpic left" title="<?=$instagram->getUsername();?>">
					<img src="<?=$instagram->getProfilePicture();?>">
				</div>
				<div class="username left"><?=$instagram->getUsername()?></div>
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
	);
	$arAllMedia = $instagram->getMediaByLocationPoints($arCityRussia36, $arParams);
?>
	<div class="items"><?
		foreach ($arAllMedia as $oMedia):
			$arMedia = getArMediaFromInsta($oMedia);
		?><div class="item left">
			<div class="info">
				<div class="author left">
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
					<div class="time right" title="<?=date('d.m.Y H:i:s', $arMedia['MEDIA']['CREATED_TIME']);?>">
						<?=date('H:i', $arMedia['MEDIA']['CREATED_TIME']);?>
					</div>
					<div class="clear"></div>
					<div class="stats right">
						<div class="comments right"><?=$arMedia['MEDIA']['COMMENTS_COUNT']?></div>
						<div class="likes right"><?=$arMedia['MEDIA']['LIKES_COUNT']?></div>
					</div>
				</div>
			</div>
			<div class="photo">
				<a href="<?=$arMedia['MEDIA']['LINK'];?>" title="<?=$arMedia['MEDIA']['CAPTION'];?>">
					<img src="<?=$arMedia['MEDIA']['URL_LOW']?>">
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