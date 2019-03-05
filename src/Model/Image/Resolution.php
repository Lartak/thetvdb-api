<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 18:51
 */

namespace TheTvDb\Model\Image;


use TheTvDb\Model\AbstractModel;

/**
 * Class Resolution
 *
 * @package TheTvDb\Model\Image
 */
class Resolution extends AbstractModel
{
	/**
	 * @var int
	 */
	private $height;
	/**
	 * @var int
	 */
	private $width;
	/**
	 * @var array
	 */
	public static $properties = [
		'height', 'width'
	];

	/**
	 * @return int
	 */
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * @param int $height
	 * @return Resolution
	 */
	public function setHeight($height)
	{
		$this->height = $height;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param int $width
	 * @return Resolution
	 */
	public function setWidth($width)
	{
		$this->width = $width;

		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return sprintf('%dx%d', $this->width, $this->height);
	}
}