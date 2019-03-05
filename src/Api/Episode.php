<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 07:01
 */

namespace TheTvDb\Api;


/**
 * Class Episode
 *
 * @package TheTvDb\Api
 */
class Episode extends AbstractApi
{
	/**
	 * @param $id
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function load($id, array $parameters = [], array $headers = [])
	{
		return $this->get("/episodes/{$id}", $parameters, $headers);
	}
}