<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:21
 */

namespace TheTvDb\Repository;

use TheTvDb\Client;

/**
 * Class AbstractRepository
 *
 * @package TheTvDb\Repository
 */
abstract class AbstractRepository implements RepositoryInterface
{
	protected $client = null;
	protected $api    = null;
	/**
	 * Constructor
	 *
	 * @param Client $client
	 */
	public function __construct(Client $client)
	{
		$this->client = $client;
	}
	/**
	 * Return the client
	 *
	 * @return Client
	 */
	public function getClient()
	{
		return $this->client;
	}
	/**
	 * @return \Symfony\Component\EventDispatcher\EventDispatcher|\TheTvDb\Http\Adapter\AdapterInterface
	 */
	public function getEventDispatcher()
	{
		return $this->client->getEventDispatcher();
	}
	/**
	 * Process query parameters
	 *
	 * @param  array $parameters
	 * @return array
	 */
	protected function parseQueryParameters(array $parameters = [])
	{
		foreach ($parameters as $key => $candidate) {
			if (is_a($candidate, 'TheTvDb\Model\Common\QueryParameter\QueryParameterInterface')) {
				$interfaces = class_implements($candidate);
				if (array_key_exists('TheTvDb\Model\Common\QueryParameter\QueryParameterInterface', $interfaces)) {
					unset($parameters[$key]);
					$parameters[$candidate->getKey()] = $candidate->getValue();
				}
			}
		}
		return $parameters;
	}
}