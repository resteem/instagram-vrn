<?php
	if (!function_exists('showArray'))
	{
		function showArray($value)
		{
			echo '<pre>', print_r($value, TRUE), '</pre>';
		}
	} // showArray

	if (!function_exists('truncate'))
	{
		function truncate($text, $cnt = 50)
		{
			if (strlen($text) > $cnt)
			{
				$text = $text . ' ';
				$text = substr($text, 0, $cnt);
				$text = substr($text, 0, strrpos($text, ' '));
				$text = trim($text) . '…';
			}
			return $text;
		}
	} // truncate

	if (!function_exists('getTplUrlLocation'))
	{
		function getTplUrlLocation($arParams)
		{
			return 'https://api.instagram.com/v1/media/search?' .
				'access_token=' . $arParams['INSTAGRAM_ACCESS_TOKEN'] .
				'&distance=' . $arParams['DISTANCE'] .
				'&min_timestamp=' . $arParams['MIN_TIMESTAMP'] .
				'&max_timestamp=' . $arParams['MAX_TIMESTAMP'] .
				'&lat=%LAT%&lng=%LNG%';
		}
	} // getTplUrlLocation

	if (!function_exists('getLocationPhotos'))
	{
		function getLocationPhotos($arPoints, $tplUrlLocationCircle)
		{
			$arPhotos = array();
			$arIDs = array();
			foreach ($arPoints as $arPoint)
			{
				$url = str_replace(array('%LAT%', '%LNG%'), array($arPoint['LAT'], $arPoint['LNG']), $tplUrlLocationCircle);
				$oData = json_decode(file_get_contents($url));
				if ($oData->meta->code == 200)
				{
					foreach ($oData->data as $oPhoto)
					{
						if (!in_array($oPhoto->id, $arIDs))
						{
							$arIDs[] = $oPhoto->id;
							$arPhotos[] = array(
								'OBJECT' => array(
									'ID' => $oPhoto->id,
									'TYPE' => $oPhoto->type,
									'FILTER' => $oPhoto->filter,
									'CREATED_TIME' => $oPhoto->created_time,
									'LINK' => $oPhoto->link,
									'URL' => $oPhoto->images->standard_resolution->url,
									'URL_LOW' => $oPhoto->images->low_resolution->url,
									'URL_THUMBNAIL' => $oPhoto->images->thumbnail->url,
									'CAPTION' => $oPhoto->caption->text,
									'LIKES_COUNT' => $oPhoto->likes->count,
									'COMMENTS_COUNT' => $oPhoto->comments->count,
								),
								'LOCATION' => array(
									'NAME' => ($oPhoto->location->name ? $oPhoto->location->name : $oPhoto->location->latitude . ', ' . $oPhoto->location->longitude),
									'ID' => $oPhoto->location->id,
									'LATITUDE' => $oPhoto->location->latitude,
									'LONGITUDE' => $oPhoto->location->longitude,
									'LINK' => 'https://www.google.ru/maps?q=' . $oPhoto->location->latitude . ',' . $oPhoto->location->longitude,
								),
								'USER' => array(
									'ID' => $oPhoto->user->id,
									'USERNAME' => $oPhoto->user->username,
									'PROFILE_PICTURE' => $oPhoto->user->profile_picture,
									'PROFILE_URL' => 'http://instagram.com/' . $oPhoto->user->username,
									'FULL_NAME' => $oPhoto->user->full_name,
								),
							);
						}
					}
				}
			}
			return $arPhotos;
		}
	} // getLocationPhotos