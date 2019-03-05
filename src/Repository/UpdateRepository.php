<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 15:03
 */

namespace TheTvDb\Repository;

use TheTvDb\Api\Updates;
use TheTvDb\Factory\AbstractFactory;
use TheTvDb\Factory\UpdateFactory;

/**
 * Class UpdateRepository
 *
 * @package TheTvDb\Repository
 */
class UpdateRepository extends AbstractRepository
{
	/**
	 * @param $fromTime
	 * @param null $toTime
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\GenericCollection
	 * @throws \Exception
	 */
	public function query($fromTime, $toTime = null, array $headers = [])
	{
		return $this->getFactory()->createCollection($this->getApi()->query($fromTime, $toTime, $headers));
	}
	/**
	 * Return the API Class
	 *
	 * @return Updates
	 */
	public function getApi()
	{
		return $this->client->getUpdatesApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return AbstractFactory
	 */
	public function getFactory()
	{
		return new UpdateFactory($this->getClient()->getHttpClient());
	}
}