<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 07/01/2019
 * Time: 02:06
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Language
 *
 * @package TheTvDb\Model\Episode
 */
class Language extends AbstractModel
{
	/**
	 * @var string
	 */
	private $episodeName;
	/**
	 * @var string
	 */
	private $overview;
	/**
	 * @var array
	 */
	public static $properties = [
		'episodeName', 'overview'
	];

	/**
	 * @return string
	 */
	public function getEpisodeName()
	{
		return $this->episodeName;
	}

	/**
	 * @param string $episodeName
	 * @return Language
	 */
	public function setEpisodeName($episodeName)
	{
		$this->episodeName = $episodeName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOverview()
	{
		return $this->overview;
	}

	/**
	 * @param string $overview
	 * @return Language
	 */
	public function setOverview($overview)
	{
		$this->overview = $overview;

		return $this;
	}
}