<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 07:32
 */

namespace TheTvDb\Api;


use TheTvDb\Exception\ApiException;

/**
 * Class Series
 *
 * @package TheTvDb\Api
 */
class Series extends AbstractApi
{
	const BASE_URI = '/series/';

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function load($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id, [], $headers);
	}

	/**
	 * @param int $id
	 * @return mixed
	 */
	public function loadViaHead($id)
	{
		return $this->head(self::BASE_URI . $id, [], []);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function getActors($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/actors', [], $headers);
	}

	/**
	 * @param int|string $id
	 * @param int $page
	 * @param array $headers
	 * @return mixed
	 */
	public function getEpisodes($id, $page = 1, $headers = [])
	{
		$parameters = [];
		if ($page !== 1) {
			$parameters['page'] = $page;
		}
		return $this->get(self::BASE_URI . $id . '/episodes', $parameters, $headers);
	}

	/**
	 * @param int $id
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function getEpisodesQuery($id, array $parameters, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/episodes/query', $parameters, $headers);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function getEpisodesQueryParams($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/episodes/query/params', [], $headers);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function getEpisodesSummary($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/episodes/summary', [], $headers);
	}

	/**
	 * @param int $id
	 * @param string|array $keys
	 * @param array $headers
	 * @return mixed
	 */
	public function filter($id, $keys, array $headers = [])
	{
		$parameters = compact('keys');
		if (is_array($keys)) {
			$parameters['keys'] = implode(',', $parameters['keys']);
		}
		return $this->get(self::BASE_URI . $id . '/filter', $parameters, $headers);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function filterParams($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/filter/params', [], $headers);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function images($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/images', [], $headers);
	}

	/**
	 * @param int $id
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function getImagesQuery($id, array $parameters, array $headers = [])
	{
		if (empty($parameters)) {
			throw new ApiException(400, 'None parameter passed');
		}
		return $this->get(self::BASE_URI . $id . '/images/query', $parameters, $headers);
	}

	/**
	 * @param int $id
	 * @param array $headers
	 * @return mixed
	 */
	public function getImagesQueryParams($id, array $headers = [])
	{
		return $this->get(self::BASE_URI . $id . '/images/query/params', [], $headers);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getSummary($id)
	{
		return $this->get(self::BASE_URI . $id . '/episodes/summary');
	}
}