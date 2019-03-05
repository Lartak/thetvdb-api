<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 07:12
 */

namespace TheTvDb\Api;


/**
 * Class Search
 *
 * @package TheTvDb\Api
 */
class Search extends AbstractApi
{
	const BASE_URI = '/search/';
	/**
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function getSeries(array $parameters, array $headers = [])
	{
		return $this->get(self::BASE_URI . 'series', $parameters, $headers);
	}
	/**
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function getSeriesParams(array $parameters = [], array $headers = [])
	{
		return $this->get(self::BASE_URI . 'series/params', $parameters, $headers);
	}
}