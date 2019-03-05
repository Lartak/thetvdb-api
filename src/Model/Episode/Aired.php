<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 09:57
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Aired
 *
 * @package TheTvDb\Model\Episode
 */
class Aired extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $episodeNumber;
	/**
	 * @var \TheTvDb\Model\Episode\AiredSeason
	 */
	private $season;
	/**
	 * @var array
	 */
	public static $properties = [
		'episodeNumber', 'season'
	];

	/**
	 * @return int
	 */
	public function getEpisodeNumber()
	{
		return $this->episodeNumber;
	}

	/**
	 * @param int $episodeNumber
	 * @return Aired
	 */
	public function setEpisodeNumber($episodeNumber)
	{
		$this->episodeNumber = $episodeNumber;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\AiredSeason
	 */
	public function getSeason()
	{
		return $this->season;
	}

	/**
	 * @param AbstractModel $season
	 * @return AbstractModel
	 */
	public function setSeason($season)
	{
		$this->season = $season;

		return $this;
	}
}