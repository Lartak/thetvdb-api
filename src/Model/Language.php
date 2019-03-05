<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 21:25
 */

namespace TheTvDb\Model;


/**
 * Class Language
 *
 * @package TheTvDb\Model
 */
class Language extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $abbreviation;
	/**
	 * @var string
	 */
	private $englishName;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'name', 'abbreviation', 'englishName'
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
	 * @return Language
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
	 * @return Language
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAbbreviation()
	{
		return $this->abbreviation;
	}

	/**
	 * @param string $abbreviation
	 * @return Language
	 */
	public function setAbbreviation($abbreviation)
	{
		$this->abbreviation = $abbreviation;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getEnglishName()
	{
		return $this->englishName;
	}

	/**
	 * @param string $englishName
	 * @return Language
	 */
	public function setEnglishName($englishName)
	{
		$this->englishName = $englishName;

		return $this;
	}
}