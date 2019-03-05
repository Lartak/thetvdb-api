<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 09:52
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Airs
 *
 * @package TheTvDb\Model\Episode
 */
class Airs extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $afterSeason;
	/**
	 * @var integer
	 */
	private $beforeEpisode;
	/**
	 * @var integer
	 */
	private $beforeSeason;
	/**
	 * @var array
	 */
	public static $properties = [
		'afterSeason', 'beforeEpisode', 'beforeSeason'
	];

	/**
	 * @return int
	 */
	public function getAfterSeason()
	{
		return $this->afterSeason;
	}

	/**
	 * @param int $afterSeason
	 * @return Airs
	 */
	public function setAfterSeason($afterSeason)
	{
		$this->afterSeason = $afterSeason;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getBeforeEpisode()
	{
		return $this->beforeEpisode;
	}

	/**
	 * @param int $beforeEpisode
	 * @return Airs
	 */
	public function setBeforeEpisode($beforeEpisode)
	{
		$this->beforeEpisode = $beforeEpisode;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getBeforeSeason()
	{
		return $this->beforeSeason;
	}

	/**
	 * @param int $beforeSeason
	 * @return Airs
	 */
	public function setBeforeSeason($beforeSeason)
	{
		$this->beforeSeason = $beforeSeason;

		return $this;
	}
}