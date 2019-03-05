<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 04:57
 */

namespace TheTvDb\Repository;


use TheTvDb\Factory\SearchFactory;

/**
 * Class SearchRepository
 *
 * @package TheTvDb\Repository
 */
class SearchRepository extends AbstractRepository
{

	/**
	 * @param $key
	 * @param $value
	 * @param array $headers
	 * @return \TheTvDb\Model\AbstractModel|\TheTvDb\Model\Common\GenericCollection
	 */
	public function series($key, $value, array $headers = [])
	{
		$data = $this->getApi()->getSeries([$key => $value], $headers);
		if (count($data['data']) > 1) {
			return $this->getFactory()->createCollection($data);
		} elseif (count($data['data']) === 1) {
			return $this->getFactory()->create($data['data'][0]);
		}
		return null;
	}

	/**
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function seriesParams(array $headers = [])
	{
		$data = $this->getApi()->getSeriesParams([], $headers);
		return $this->getFactory()->createCollectionToCommaSeparatedString($data['data']);
	}
	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\Search
	 */
	public function getApi()
	{
		return $this->client->getSearchApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return SearchFactory
	 */
	public function getFactory()
	{
		return new SearchFactory($this->client->getHttpClient());
	}
}