<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 06:13
 */

namespace TheTvDb\Api;


use TheTvDb\Exception\TokenMissingException;

/**
 * Class Authentication
 *
 * @package TheTvDb\Api
 */
class Authentication extends AbstractApi
{
	/**
	 * @param array $credentials
	 * @param array $headers
	 * @return mixed
	 */
	public function login(array $credentials, array $headers = [])
	{
		$headers['Content-Type'] = 'application/json';
		return $this->postJson('/login', $credentials, [], $headers);
	}

	/**
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function refreshToken(array $parameters = [], array $headers = [])
	{
		if (is_null($this->client->getToken())) {
			throw new TokenMissingException('An Token was not configured, please configure the `token` option with an correct Token() object.');
		}
		return $this->get('/refresh_token', $parameters, $headers);
	}
}