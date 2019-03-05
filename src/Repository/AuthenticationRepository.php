<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 12:49
 */

namespace TheTvDb\Repository;


use TheTvDb\Auth;
use TheTvDb\Factory\AbstractFactory;
use TheTvDb\Token;

/**
 * Class AuthenticationRepository
 *
 * @package TheTvDb\Repository
 */
class AuthenticationRepository extends AbstractRepository
{

	/**
	 * @param \TheTvDb\Auth $auth
	 * @param array $headers
	 * @return \TheTvDb\Token
	 * @throws \TheTvDb\Exception\NotAuthorizedException
	 * @throws \Exception
	 */
	public function login(Auth $auth, array $headers = [])
	{
		$data = $this->getApi()->login($auth->toArray(), $headers);
		$token = new Token();
		if (array_key_exists('token', $data)) {
			$data = $data['token'];
		}
		$token
			->setToken($data)
			->setCreatedAt(new \DateTime('now'));
		return $token;
	}

	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\Authentication
	 */
	public function getApi()
	{
		return $this->client->getAuthenticationApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return AbstractFactory
	 */
	public function getFactory()
	{
		return null;
	}
}