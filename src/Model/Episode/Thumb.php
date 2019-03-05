<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 10:08
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class Thumb
 *
 * @package TheTvDb\Model\Episode
 */
class Thumb extends AbstractModel
{
	/**
	 * @var string|null
	 */
	private $added;
	/**
	 * @var integer
	 */
	private $author;
	/**
	 * @var string
	 */
	private $height;
	/**
	 * @var string
	 */
	private $width;
	/**
	 * @var array
	 */
	public static $properties = [
		'added', 'author', 'height', 'width'
	];

	/**
	 * @return string|null
	 */
	public function getAdded()
	{
		return $this->added;
	}

	/**
	 * @param string $added
	 * @return Thumb
	 * @throws \Exception
	 */
	public function setAdded($added)
	{
		$this->added = strlen($added) ? $added : null;
		if (!is_null($this->added)) {
			$this->added = new \DateTime($added);
		}
		return $this;
	}

	/**
	 * @return int
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param int $author
	 * @return Thumb
	 */
	public function setAuthor($author)
	{
		$this->author = $author;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHeight()
	{
		return $this->height;
	}

	/**
	 * @param string $height
	 * @return Thumb
	 */
	public function setHeight($height)
	{
		$this->height = $height;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getWidth()
	{
		return $this->width;
	}

	/**
	 * @param string $width
	 * @return Thumb
	 */
	public function setWidth($width)
	{
		$this->width = $width;

		return $this;
	}
}