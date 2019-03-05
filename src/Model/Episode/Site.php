<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 10:04
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Site
 *
 * @package TheTvDb\Model\Episode
 */
class Site extends AbstractModel
{
	/**
	 * @var float
	 */
	private $rating;
	/**
	 * @var integer
	 */
	private $ratingCount;
	/**
	 * @var array
	 */
	public static $properties = [
		'rating', 'ratingCount'
	];

	/**
	 * @return float
	 */
	public function getRating()
	{
		return $this->rating;
	}

	/**
	 * @param float $rating
	 * @return Site
	 */
	public function setRating($rating)
	{
		$this->rating = $rating;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getRatingCount()
	{
		return $this->ratingCount;
	}

	/**
	 * @param int $ratingCount
	 * @return Site
	 */
	public function setRatingCount($ratingCount)
	{
		$this->ratingCount = $ratingCount;

		return $this;
	}
}