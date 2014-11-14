<?
	require_once(getenv('DOCUMENT_ROOT') . '/_/auth_configs.php');
	require_once('Instagram.class.php');

	class App
	{
		const DEFAULT_DISTANCE = '5000';

		protected static $instance = NULL;

		private $_isDevMode = FALSE;
		private $_instagram = NULL;
		private $_cookieExpire = 0;

		public static function getInstance()
		{
			return is_null(self::$instance) ? self::$instance = new self() : self::$instance;
		}

		protected function __clone()
		{

		}

		protected function __construct()
		{
			$arInstaParams = array(
				'CLIENT_ID' => INSTAGRAM_CLIENT_ID,
				'CLIENT_SECRET' => INSTAGRAM_CLIENT_SECRET,
				'REDIRECT_URI' => INSTAGRAM_REDIRECT_URI,
			);
			$this->_instagram = new Instagram($arInstaParams);
			$this->_isDevMode = (strpos($_SERVER['HTTP_HOST'], 'localhost') === 0);
			// for auth cookie
			$this->_cookieExpire = time() + 60 * 60 * 24 * 365; // 1 year
		}

		public static function showArray($value)
		{
			echo '<pre>', print_r($value, TRUE), '</pre>';
		}

		public static function redirect($URL)
		{
			// header('Location: ' . $URL);
			die('<script>location.href = "' . $URL . '"</script>');
		}

		public static function removeCookie($name)
		{
			setcookie($name, '', time() - 3600);
		}

		public function isDevMode()
		{
			return $this->_isDevMode;
		}

		public function isAuthorized()
		{
			$token = $this->getAccessToken();
			return !empty($token);
		}

		public function getAuthUrl()
		{
			return $this->_instagram->getAuthUrl();
		}

		public function getAuthToken($code)
		{
			return $this->_instagram->getAuthToken($code);
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
			if (!array_key_exists('ACCESS_TOKEN', $arParams)) $arParams['ACCESS_TOKEN'] = $this->getAccessToken();
			$arMedia = array();
			$oInstaMedias = $this->_instagram->getMediaByLocationPoint($arPoint, $arParams);
			foreach ($oInstaMedias as $key => $oInstaMedia)
			{
				$arMedia[$key] = $this->_getArMediaFromInsta($oInstaMedia);
			}
			return $arMedia;
		}

		public function getMediaByLocationId($location_id, $arParams)
		{
			if (!array_key_exists('ACCESS_TOKEN', $arParams)) $arParams['ACCESS_TOKEN'] = $this->getAccessToken();
			$arMedia = array();
			$oInstaMedias = $this->_instagram->getMediaByLocationId($location_id, $arParams);
			foreach ($oInstaMedias as $key => $oInstaMedia)
			{
				$arMedia[$key] = $this->_getArMediaFromInsta($oInstaMedia);
			}
			return $arMedia;
		}

		private function _getArMediaFromInsta($oInstaMedia)
		{
			$arMedia = array(
				'MEDIA' => array(
					'ID' => $oInstaMedia->id,
					'TYPE' => $oInstaMedia->type,
					'FILTER' => $oInstaMedia->filter,
					'CREATED_TIME' => $oInstaMedia->created_time,
					'LINK' => $oInstaMedia->link,
					'URL' => $oInstaMedia->images->standard_resolution->url,
					'URL_LOW' => $oInstaMedia->images->low_resolution->url,
					'URL_THUMBNAIL' => $oInstaMedia->images->thumbnail->url,
					'CAPTION' => $oInstaMedia->caption->text,
					'LIKES_COUNT' => $oInstaMedia->likes->count,
					'COMMENTS_COUNT' => $oInstaMedia->comments->count,
				),
				'LOCATION' => array(
					'NAME' => ($oInstaMedia->location->name ? $oInstaMedia->location->name : $oInstaMedia->location->latitude . ', ' . $oInstaMedia->location->longitude),
					'ID' => $oInstaMedia->location->id,
					'LATITUDE' => $oInstaMedia->location->latitude,
					'LONGITUDE' => $oInstaMedia->location->longitude,
					'GM_LINK' => 'https://www.google.ru/maps?q=' . $oInstaMedia->location->latitude . ',' . $oInstaMedia->location->longitude,
					// 'LINK' => '/location?LAT=' . $oInstaMedia->location->latitude . '&LNG=' . $oInstaMedia->location->longitude,
					'LINK' => (
						$oInstaMedia->location->id ?
						'/location?ID=' . $oInstaMedia->location->id :
						'/location?LAT=' . $oInstaMedia->location->latitude . '&LNG=' . $oInstaMedia->location->longitude
					),
				),
				'USER' => array(
					'ID' => $oInstaMedia->user->id,
					'USERNAME' => $oInstaMedia->user->username,
					'PROFILE_PICTURE' => $oInstaMedia->user->profile_picture,
					'PROFILE_URL' => 'http://instagram.com/' . $oInstaMedia->user->username,
					'FULL_NAME' => $oInstaMedia->user->full_name,
				),
			);
			return $arMedia;
		}

		public function logout()
		{
			self::removeCookie('ACCESS_TOKEN');
			self::removeCookie('USERNAME');
			self::removeCookie('PROFILE_PICTURE');
			self::removeCookie('USER_ID');
		}

		public function setAccessToken($value)
		{
			setcookie('ACCESS_TOKEN', $value, $this->_cookieExpire);
		}

		public function getAccessToken()
		{
			return $_COOKIE['ACCESS_TOKEN'];
		}

		public function setUsername($value)
		{
			setcookie('USERNAME', $value, $this->_cookieExpire);
		}

		public function getUsername()
		{
			return $_COOKIE['USERNAME'];
		}

		public function setProfilePicture($value)
		{
			setcookie('PROFILE_PICTURE', $value, $this->_cookieExpire);
		}

		public function getProfilePicture()
		{
			return $_COOKIE['PROFILE_PICTURE'];
		}

		public function setUserId($value)
		{
			setcookie('USER_ID', $value, $this->_cookieExpire);
		}

		public function getUserId()
		{
			return $_COOKIE['USER_ID'];
		}
	}