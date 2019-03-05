<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 05:49
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Image
 *
 * @package TheTvDb\Model\Series
 */
class Image extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $fanArt;
	/**
	 * @var integer
	 */
	private $poster;
	/**
	 * @var integer
	 */
	private $season;
	/**
	 * @var integer
	 */
	private $seasonWide;
	/**
	 * @var integer
	 */
	private $series;
	/**
	 * @var array
	 */
	public static $properties = [
		'fanArt', 'poster', 'season', 'seasonWide', 'series'
	];

	/**
	 * @return int
	 */
	public function getFanArt()
	{
		return $this->fanArt;
	}

	/**
	 * @param int $fanArt
	 * @return Image
	 */
	public function setFanArt($fanArt)
	{
		$this->fanArt = $fanArt;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPoster()
	{
		return $this->poster;
	}

	/**
	 * @param int $poster
	 * @return Image
	 */
	public function setPoster($poster)
	{
		$this->poster = $poster;

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
	 * @return Image
	 */
	public function setSeason($season)
	{
		$this->season = $season;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeasonWide()
	{
		return $this->seasonWide;
	}

	/**
	 * @param int $seasonWide
	 * @return Image
	 */
	public function setSeasonWide($seasonWide)
	{
		$this->seasonWide = $seasonWide;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeries()
	{
		return $this->series;
	}

	/**
	 * @param int $series
	 * @return Image
	 */
	public function setSeries($series)
	{
		$this->series = $series;

		return $this;
	}
}