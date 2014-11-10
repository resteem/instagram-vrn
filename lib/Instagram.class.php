<?php
	class Instagram
	{
		const URL_MEDIA_SEARCH = 'https://api.instagram.com/v1/media/search';
		const URL_AUTH = 'https://api.instagram.com/oauth/authorize';
		const URL_ACCESS_TOKEN = 'https://api.instagram.com/oauth/access_token';

		private $_clientId;
		private $_clientSecret;
		private $_redirectUri;

		private $_accessToken;
		private $_username;
		private $_profilePicture;
		private $_userId;

		function __construct($arParams)
		{
			$this->setClientId($arParams['CLIENT_ID']);
			$this->setClientSecret($arParams['CLIENT_SECRET']);
			$this->setRedirectUri($arParams['REDIRECT_URI']);
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

		// getters-setters

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

		public function setAccessToken($value)
		{
			$this->_accessToken = $value;
		}
		public function getAccessToken()
		{
			return $this->_accessToken;
		}

		public function setUsername($value)
		{
			$this->_username = $value;
		}
		public function getUsername()
		{
			return $this->_username;
		}

		public function setProfilePicture($value)
		{
			$this->_profilePicture = $value;
		}
		public function getProfilePicture()
		{
			return $this->_profilePicture;
		}

		public function setUserId($value)
		{
			$this->_userId = $value;
		}
		public function getUserId()
		{
			return $this->_userId;
		}

	}
?>