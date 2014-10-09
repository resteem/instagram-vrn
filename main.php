<!DOCTYPE html>
<html>
<head>
	<title>Воронеж в Инстаграме</title>
</head>
<body>
	<h1>Что сфотографировали в Воронеже за последние сутки</h1>
<?php
	include_once('_/config.php');

	if (!function_exists('showArray'))
	{
		function showArray($value)
		{
			echo '<pre>', print_r($value, TRUE), '</pre>';
		}
	} // showArray

	// Draw circles on Google maps - http://www.mapdevelopers.com/draw-circle-tool.php
	$arCircles5000_VORONEZH = array(
		array( // center
			'LAT' => '51.66448760893037',
			'LNG' => '39.226183673046876',
		),
		array( // up-left center
			'LAT' => '51.724973',
			'LNG' => '39.257229',
		),
		array( // soviet
			'LAT' => '51.597998109841136',
			'LNG' => '39.132799883984376',
		),
		array( // komintern
			'LAT' => '51.67726287930439',
			'LNG' => '39.1286800109375',
		),
		array( // lenin
			'LAT' => '51.74193555156363',
			'LNG' => '39.15339924921875',
		),
		array( // left
			'LAT' => '51.60738073741625',
			'LNG' => '39.25776936640625',
		),
	);

	$now = time();
	$arParams = array(
		'DISTANCE' => '5000',
		'MIN_TIMESTAMP' => $now - (1 * 24 * 60 * 60), // yesterday
		'MAX_TIMESTAMP' => $now,
	);
	$tplUrlLocationCircle = 'https://api.instagram.com/v1/media/search?access_token=' . $INSTAGRAM_ACCESS_TOKEN .
			'&distance=' . $arParams['DISTANCE'] .
			'&min_timestamp=' . $arParams['MIN_TIMESTAMP'] .
			'&max_timestamp=' . $arParams['MAX_TIMESTAMP'] .
			'&lat=%LAT%&lng=%LNG%';
	foreach ($arCircles5000_VORONEZH as $arPoint)
	{
		$url = str_replace(array('%LAT%', '%LNG%'), array($arPoint['LAT'], $arPoint['LNG']), $tplUrlLocationCircle);
		$oData = json_decode(file_get_contents($url));
		if ($oData->meta->code == 200)
		{
			showArray($oData->data); exit;
			/*
			foreach ($oData->data as $oPhoto)
			{
				?>
					<a href="<?php echo $oPhoto->link;?>" title="<?php echo $oPhoto->user->username;?>">
						<img src="<?php echo $oPhoto->images->thumbnail->url;?>">
					</a>
				<?php
			}
			*/
		}
	}
?>
</body>
</html>