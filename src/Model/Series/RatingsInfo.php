<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 18:59
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class RatingsInfo
 *
 * @package TheTvDb\Model\Series
 */
class RatingsInfo extends AbstractModel
{
	/**
	 * @var float
	 */
	private $average;
	/**
	 * @var int
	 */
	private $count;
	/**
	 * @var array
	 */
	public static $properties = [
		'average', 'count'
	];

	/**
	 * @return float
	 */
	public function getAverage()
	{
		return $this->average;
	}

	/**
	 * @param float $average
	 * @return RatingsInfo
	 */
	public function setAverage($average)
	{
		$this->average = $average;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}

	/**
	 * @param int $count
	 * @return RatingsInfo
	 */
	public function setCount($count)
	{
		$this->count = $count;

		return $this;
	}
}