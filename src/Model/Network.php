<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 01:14
 */

namespace TheTvDb\Model;


/**
 * Class Network
 *
 * @package TheTvDb\Model
 */
class Network extends AbstractModel
{
	/**
	 * @var string
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'name'
	];

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $id
	 * @return Network
	 */
	public function setId($id)
	{
		$this->id = $id;

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
	 * @return Network
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}
}