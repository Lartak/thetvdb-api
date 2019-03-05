<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 05:31
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class ImageActor
 *
 * @package TheTvDb\Model\Series
 */
class ImageActor extends AbstractModel
{
	/**
	 * @var \DateTime
	 */
	private $added;
	/**
	 * @var string
	 */
	private $author;
	/**
	 * @var string
	 */
	private $path;
	/**
	 * @var array
	 */
	public static $properties = [
		'added', 'author', 'path'
	];

	/**
	 * @return \DateTime
	 */
	public function getAdded()
	{
		return $this->added;
	}

	/**
	 * @param string $added
	 * @return ImageActor
	 * @throws \Exception
	 */
	public function setAdded($added)
	{
		$this->added = new \DateTime($added);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 * @return ImageActor
	 */
	public function setAuthor($author)
	{
		$this->author = $author;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 * @return ImageActor
	 */
	public function setPath($path)
	{
		$this->path = $path;

		return $this;
	}
}