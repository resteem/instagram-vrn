<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<title>Воронеж в Инстаграме</title>
</head>
<body>
	<h1 class="logo">Что сфотографировали в Воронеже за последние сутки</h1>
<?
	include_once('_/auth_configs.php');
	include_once('lib/functions.php');
	include_once('lib/city_russia_36.php');

	$now = time();
	$arParams = array(
		'DISTANCE' => '5000',
		'MIN_TIMESTAMP' => $now - (60 * 60 * 24), // yesterday
		'MAX_TIMESTAMP' => $now,
		'INSTAGRAM_ACCESS_TOKEN' => $INSTAGRAM_ACCESS_TOKEN,
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
							<a class="uline" href="<?=$arPhoto['LOCATION']['LINK'];?>" title="<?=($arPhoto['LOCATION']['NAME'] ? $arPhoto['LOCATION']['NAME'] : $arPhoto['LOCATION']['NAME_BY_COORD']);?>">
								Location
							</a>
						</div>
					</div>
				</div>
				<div class="right">
					<div class="time right" title="<?=date('d.m.Y H:i:s', $arPhoto['OBJECT']['CREATED_TIME']);?>">
						<?=date('H:i', $arPhoto['OBJECT']['CREATED_TIME']);?>
					</div>
					<div class="clear"></div>
					<div class="stats right">
						<div class="comments right"><?=$arPhoto['OBJECT']['COMMENTS_COUNT']?></div>
						<div class="likes right"><?=$arPhoto['OBJECT']['LIKES_COUNT']?></div>
					</div>
				</div>
			</div>
			<div class="photo">
				<a href="<?=$arPhoto['OBJECT']['LINK'];?>" title="<?=$arPhoto['OBJECT']['CAPTION'];?>">
					<img src="<?=$arPhoto['OBJECT']['URL_LOW']?>">
				</a>
			</div>
		</div><?
		endforeach;
	?></div>
</body>
</html>