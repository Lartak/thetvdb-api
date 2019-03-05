<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:27
 */

namespace TheTvDb\Repository;

use TheTvDb\Factory\AbstractFactory;
use TheTvDb\Factory\EpisodeFactory;

/**
 * Class EpisodeRepository
 *
 * @package TheTvDb\Repository
 */
class EpisodeRepository extends AbstractRepository
{
	/**
	 * @param int $id
	 * @param array $parameters
	 * @param array $headers
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function load($id, array $parameters = [], array $headers = [])
	{
		return $this->getFactory()->create($this->getApi()->load($id, $parameters, $headers));
	}

	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\Episode
	 */
	public function getApi()
	{
		return $this->client->getEpisodeApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return AbstractFactory
	 */
	public function getFactory()
	{
		return new EpisodeFactory($this->client->getHttpClient());
	}
}