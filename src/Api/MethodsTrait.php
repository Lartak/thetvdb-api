<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 06:10
 */

namespace TheTvDb\Api;


/**
 * Trait MethodsTrait
 *
 * @category $Category$
 * @package TheTvDb\Api
 * @author Lartak
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
trait MethodsTrait
{
	/**
	 * @return \TheTvDb\Api\Authentication
	 */
	public function getAuthenticationApi()
	{
		return new \TheTvDb\Api\Authentication($this);
	}

	/**
	 * @return \TheTvDb\Api\Episode
	 */
	public function getEpisodeApi()
	{
		return new \TheTvDb\Api\Episode($this);
	}

	/**
	 * @return \TheTvDb\Api\Language
	 */
	public function getLanguageApi()
	{
		return new \TheTvDb\Api\Language($this);
	}

	/**
	 * @return \TheTvDb\Api\Search
	 */
	public function getSearchApi()
	{
		return new \TheTvDb\Api\Search($this);
	}

	/**
	 * @return \TheTvDb\Api\Series
	 */
	public function getSeriesApi()
	{
		return new \TheTvDb\Api\Series($this);
	}

	/**
	 * @return \TheTvDb\Api\Updates
	 */
	public function getUpdatesApi()
	{
		return new \TheTvDb\Api\Updates($this);
	}

	/**
	 * @return \TheTvDb\Api\User
	 */
	public function getUserApi()
	{
		return new \TheTvDb\Api\User($this);
	}
}