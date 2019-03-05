<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 05:28
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Actor
 *
 * @package TheTvDb\Model\Series
 */
class Actor extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var \TheTvDb\Model\Series\ImageActor
	 */
	private $image;
	/**
	 * @var \DateTime
	 */
	private $lastUpdated;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $role;
	/**
	 * @var integer
	 */
	private $seriesId;
	/**
	 * @var int
	 */
	private $sortOrder;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'image', 'lastUpdated', 'name', 'role', 'seriesId', 'sortOrder'
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
	 * @return Actor
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Series\ImageActor
	 */
	public function getImage()
	{
		return $this->image;
	}

	/**
	 * @param \TheTvDb\Model\Series\ImageActor|AbstractModel $image
	 * @return Actor
	 */
	public function setImage($image)
	{
		$this->image = $image;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * @param string $lastUpdated
	 * @return Actor
	 * @throws \Exception
	 */
	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = new \DateTime($lastUpdated);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Actor
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @param string $role
	 * @return Actor
	 */
	public function setRole($role)
	{
		$this->role = $role;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeriesId()
	{
		return $this->seriesId;
	}

	/**
	 * @param int $seriesId
	 * @return Actor
	 */
	public function setSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSortOrder()
	{
		return $this->sortOrder;
	}

	/**
	 * @param int $sortOrder
	 * @return Actor
	 */
	public function setSortOrder($sortOrder)
	{
		$this->sortOrder = $sortOrder;

		return $this;
	}
}