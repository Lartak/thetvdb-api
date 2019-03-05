<?php
/**
 * User: Lartak
 * Date: 04/01/2019
 * Time: 00:00
 */

namespace TheTvDb;


use TheTvDb\Exception\ApiException;
use TheTvDb\Exception\NotAuthorizedException;
use TheTvDb\Model\AbstractModel;

/**
 * Class ApiToken
 *
 * @package TheTvDb
 */
class Auth extends AbstractModel
{
	/** Api Key Index */
	const CLIENT_ID = 'apiKey';
	/** User Key Index */
	const CLIENT_SECRET = 'userKey';
	const USERNAME = 'username';

	/**
	 * @var string
	 */
	private $apiKey;
	/**
	 * @var string
	 */
	private $userKey;
	/**
	 * @var string
	 */
	private $username;
	/**
	 * @var array
	 */
	public static $properties = [
		'apiKey', 'userKey', 'username'
	];

	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @param string $apiKey
	 * @return Auth
	 */
	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserKey()
	{
		return $this->userKey;
	}

	/**
	 * @param string $userKey
	 * @return Auth
	 */
	public function setUserKey($userKey)
	{
		$this->userKey = $userKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return Auth
	 */
	public function setUsername($username)
	{
		$this->username = $username;

		return $this;
	}

	/**
	 * @return array
	 * @throws \TheTvDb\Exception\NotAuthorizedException
	 */
	public function toArray()
	{
		if (is_null($this->apiKey) || is_null($this->userKey) === 0 || is_null($this->username)) {
			if (is_null($this->apiKey)) {
				$error = 'Api Key';
			} elseif (is_null($this->userKey)) {
				$error = 'User Key';
			} else {
				$error = 'Username';
			}
			/** @var string $error */
			$error = sprintf('The [%s] is required', $error);
			throw new NotAuthorizedException(ApiException::STATUS_NOT_AUTHORIZED, $error);
		}
		return [
			strtolower(self::CLIENT_ID)     =>  $this->apiKey,
			strtolower(self::CLIENT_SECRET) =>  $this->userKey,
			self::USERNAME                      =>  $this->username
		];
	}

	/**
	 * @return string
	 * @throws \TheTvDb\Exception\NotAuthorizedException
	 */
	public function toJson()
	{
		return json_encode($this->toArray());
	}
}