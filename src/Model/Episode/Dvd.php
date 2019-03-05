<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 10:01
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Dvd
 *
 * @package TheTvDb\Model\Episode
 */
class Dvd extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $chapter;
	/**
	 * @var string|null
	 */
	private $discId;
	/**
	 * @var integer
	 */
	private $episodeNumber;
	/**
	 * @var integer
	 */
	private $season;
	/**
	 * @var array
	 */
	public static $properties = [
		'chapter', 'discId', 'episodeNumber', 'season'
	];

	/**
	 * @return int
	 */
	public function getChapter()
	{
		return $this->chapter;
	}

	/**
	 * @param int $chapter
	 * @return Dvd
	 */
	public function setChapter($chapter)
	{
		$this->chapter = $chapter;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getDiscId()
	{
		return $this->discId;
	}

	/**
	 * @param string $discId
	 * @return Dvd
	 */
	public function setDiscId($discId)
	{
		$this->discId = strlen($discId) ? $discId : null;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getEpisodeNumber()
	{
		return $this->episodeNumber;
	}

	/**
	 * @param int $episodeNumber
	 * @return Dvd
	 */
	public function setEpisodeNumber($episodeNumber)
	{
		$this->episodeNumber = $episodeNumber;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeason()
	{
		return $this->season;
	}

	/**
	 * @param int $season
	 * @return Dvd
	 */
	public function setSeason($season)
	{
		$this->season = $season;

		return $this;
	}
}