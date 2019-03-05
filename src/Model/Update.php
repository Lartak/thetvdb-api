<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 14:56
 */

namespace TheTvDb\Model;


/**
 * Class Update
 *
 * @package TheTvDb\Model
 */
class Update extends AbstractModel
{
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var int
	 */
	private $lastUpdated;

	public static $properties = [
		'id', 'lastUpdated'
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
	 * @return Update
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Return a timestamp
	 * @return int
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * @param int $lastUpdated
	 * @return Update
	 */
	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = $lastUpdated;

		return $this;
	}
}