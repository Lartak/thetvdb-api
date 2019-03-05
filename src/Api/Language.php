<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 07:07
 */

namespace TheTvDb\Api;


/**
 * Class Language
 *
 * @package TheTvDb\Api
 */
class Language extends AbstractApi
{

	const BASE_URI = '/languages';

	/**
	 * @param int $id
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function getLanguage($id, array $parameters = [], array $headers = [])
	{
		return $this->get( self::BASE_URI . "/{$id}", $parameters, $headers);
	}

	/**
	 * @param array $parameters
	 * @param array $headers
	 * @return mixed
	 */
	public function getLanguages(array $parameters = [], array $headers = [])
	{
		return $this->get(self::BASE_URI, $parameters, $headers);
	}
}