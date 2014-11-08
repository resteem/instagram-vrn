<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script src="script/script.js"></script>
	<link rel="stylesheet" type="text/css" href="style/style.css">
	<title>Воронеж в Инстаграме</title>
</head>
<body>
<header>
	<div class="logo left" title="Воронеж в Инстаграме"></div>
	<div class="header left">
		<h1>Воронеж в Инстаграме</h1>
		<h2>Что сегодня фотографируют в Воронеже</h2>
	</div>
	<div class="clear"></div>
</header>
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
							<div class="location_a_wrapper">
								<a class="uline" href="<?=$arPhoto['LOCATION']['LINK'];?>" title="<?=$arPhoto['LOCATION']['NAME'];?>">
									<?=$arPhoto['LOCATION']['NAME'];?>
								</a>
							</div>
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
	?>
	<div class="clear"></div>
	</div>
<footer>
	© 2014
</footer>
</body>
</html>