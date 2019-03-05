<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 21:35
 */

namespace TheTvDb\Repository;


use TheTvDb\Factory\LanguageFactory;

/**
 * Class LanguageRepository
 *
 * @package TheTvDb\Repository
 */
class LanguageRepository extends AbstractRepository
{

	/**
	 * @param $id
	 * @param array $parameters
	 * @param array $headers
	 * @return \TheTvDb\Model\Language
	 */
	public function language($id, array $parameters = [], array $headers = [])
	{
		return $this->getFactory()->create($this->getApi()->getLanguage((int)$id, $parameters, $headers));
	}

	/**
	 * @param array $parameters
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function languages(array $parameters = [], array $headers = [])
	{
		return $this->getFactory()->createCollection($this->getApi()->getLanguages($parameters, $headers));
	}

	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\Language
	 */
	public function getApi()
	{
		return $this->client->getLanguageApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return LanguageFactory
	 */
	public function getFactory()
	{
		return new LanguageFactory($this->client->getHttpClient());
	}
}