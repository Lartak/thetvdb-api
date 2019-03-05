<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 23:53
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class AiredSeason
 *
 * @package TheTvDb\Model\Episode
 */
class AiredSeason extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var integer
	 */
	private $number;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'number'
	];

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return AiredSeason
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNumber()
	{
		return $this->number;
	}

	/**
	 * @param int $number
	 * @return AiredSeason
	 */
	public function setNumber($number)
	{
		$this->number = $number;

		return $this;
	}
}