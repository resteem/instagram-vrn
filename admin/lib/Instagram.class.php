<?
	class Instagram
	{
		const URL_LOGOUT = 'https://instagram.com/accounts/logout/';
		const URL_MEDIA_SEARCH = 'https://api.instagram.com/v1/media/search';
		const URL_MEDIA_LOCATION_ID = 'https://api.instagram.com/v1/locations/%LOCATION_ID%/media/recent';
		const URL_MEDIA_USER_ID = 'https://api.instagram.com/v1/users/%USER_ID%/media/recent/';
		const URL_MEDIA_TAGS = 'https://api.instagram.com/v1/tags/%TAGS%/media/recent';
		const URL_AUTH = 'https://api.instagram.com/oauth/authorize';
		const URL_ACCESS_TOKEN = 'https://api.instagram.com/oauth/access_token';

		private $_clientId = '';
		private $_clientSecret = '';
		private $_redirectUri = '';

		function __construct($arParams)
		{
			$this->setClientId($arParams['CLIENT_ID']);
			$this->setClientSecret($arParams['CLIENT_SECRET']);
			$this->setRedirectUri($arParams['REDIRECT_URI']);
		}

		public function getMediaByLocationId($location_id, $arParams)
		{
			$url = self::URL_MEDIA_LOCATION_ID .
				'?access_token=' . $arParams['ACCESS_TOKEN']
				. '&min_timestamp=' . $arParams['MIN_TIMESTAMP']
				. '&max_timestamp=' . $arParams['MAX_TIMESTAMP']
			;
			$url = str_replace('%LOCATION_ID%', urlencode($location_id), $url);
			return $this->_getMediaByUrl($url);
		}

		public function getMediaByUserId($user_id, $arParams)
		{
			$url = self::URL_MEDIA_USER_ID .
				// '?client_id=' . $this->getClientId() .
				// or
				'?access_token=' . $arParams['ACCESS_TOKEN']
				. '&count=' . $arParams['COUNT']
				. '&min_id=' . $arParams['MIN_ID']
				. '&max_id=' . $arParams['MAX_ID']
				. '&min_timestamp=' . $arParams['MIN_TIMESTAMP']
				. '&max_timestamp=' . $arParams['MAX_TIMESTAMP']
			;
			$url = str_replace('%USER_ID%', urlencode($user_id), $url);
			return $this->_getMediaByUrl($url);
		}

		public function getMediaByTags($tags, $arParams)
		{
			$url = self::URL_MEDIA_TAGS .
				'?access_token=' . $arParams['ACCESS_TOKEN']
				. '&count=' . $arParams['COUNT']
				. '&min_tag_id=' . $arParams['MIN_TAG_ID']
				. '&max_tag_id=' . $arParams['MAX_TAG_ID']
			;
			$url = str_replace('%TAGS%', urlencode($tags), $url);
			return $this->_getMediaByUrl($url);
		}

		public function getUserIdByLogin($login)
		{
			// @TODO get
			return 0;
		}

		public function getMediaByLocationPoints($arPoints, $arParams)
		{
			$arMedia = array();
			foreach ($arPoints as $arPoint)
			{
				$arTmp = $this->getMediaByLocationPoint($arPoint, $arParams);
				$arMedia = array_merge($arMedia, $arTmp);
			}
			return $arMedia;
		}

		public function getMediaByLocationPoint($arPoint, $arParams)
		{
			$url = self::URL_MEDIA_SEARCH .
				'?access_token=' . $arParams['ACCESS_TOKEN']
				. '&distance=' . $arParams['DISTANCE']
				. '&min_timestamp=' . $arParams['MIN_TIMESTAMP']
				. '&max_timestamp=' . $arParams['MAX_TIMESTAMP']
				. '&lat=%LAT%&lng=%LNG%';
			$url = str_replace(array('%LAT%', '%LNG%'), array(urlencode($arPoint['LAT']), urlencode($arPoint['LNG'])), $url);
			return $this->_getMediaByUrl($url);
		}

		private function _getMediaByUrl($url)
		{
			$arMedia = array();
			$oData = json_decode(file_get_contents($url));
			if ($oData->meta->code == 200)
			{
				foreach ($oData->data as $oMedia)
				{
					$arMedia[$oMedia->id] = $oMedia;
				}
			}
			return $arMedia;
		}

		public function getAuthUrl()
		{
			return self::URL_AUTH . '?client_id=' . $this->getClientId() . '&redirect_uri=' . urlencode($this->getRedirectUri()) . '&response_type=code';
		}

		public function getAuthToken($code)
		{
			$arContent = array(
				'grant_type' => 'authorization_code',
				'client_id' => $this->getClientId(),
				'client_secret' => $this->getClientSecret(),
				'redirect_uri' => $this->getRedirectUri(),
				'code' => $code
			);
			$arParams = array(
				'http' => array(
					'method' => 'POST',
					'header' => 'Accept: application/json',
					'content' => http_build_query($arContent)
				)
			);
			$ctx = stream_context_create($arParams);
			$f = fopen(self::URL_ACCESS_TOKEN, 'rb', FALSE, $ctx);
			$response = stream_get_contents($f);
			fclose($f);
			return json_decode($response);
		}

		public function setClientId($value)
		{
			$this->_clientId = $value;
		}

		public function getClientId()
		{
			return $this->_clientId;
		}

		public function setClientSecret($value)
		{
			$this->_clientSecret = $value;
		}

		public function getClientSecret()
		{
			return $this->_clientSecret;
		}

		public function setRedirectUri($value)
		{
			$this->_redirectUri = $value;
		}

		public function getRedirectUri()
		{
			return $this->_redirectUri;
		}
	}