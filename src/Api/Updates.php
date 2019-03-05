<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 08:13
 */

namespace TheTvDb\Api;


/**
 * Class Updates
 *
 * @package TheTvDb\Api
 */
class Updates extends AbstractApi
{
	const BASE_URI = '/updated/query';

	/**
	 * @param string $fromTime
	 * @param null|string $toTime
	 * @param array $headers
	 * @return mixed
	 * @throws \Exception
	 */
	public function query($fromTime, $toTime = null, array $headers = [])
	{
		$parameters = compact('fromTime');
		if (is_string($fromTime)) {
			$parameters['fromTime'] = (new \DateTime($fromTime))->getTimestamp();
		}
		if (!is_null($toTime) && is_string($toTime)) {
			$parameters['toTime'] = (new \DateTime($toTime))->getTimestamp();
		}
		return $this->get(self::BASE_URI, $parameters, $headers);
	}

	/**
	 * @param array $headers
	 * @return mixed
	 */
	public function queryParams(array $headers = [])
	{
		return $this->get(self::BASE_URI . '/params', [], $headers);
	}
}