<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 02:16
 */

namespace TheTvDb\Model;


/**
 * Class Rating
 *
 * @package TheTvDb\Model
 */
class Rating extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $itemId;
	/**
	 * @var integer
	 */
	private $note;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var array
	 */
	public static $properties = [
		'itemId', 'note', 'type'
	];

	/**
	 * @return int
	 */
	public function getItemId()
	{
		return $this->itemId;
	}

	/**
	 * @param int $itemId
	 * @return Rating
	 */
	public function setItemId($itemId)
	{
		$this->itemId = $itemId;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNote()
	{
		return $this->note;
	}

	/**
	 * @param int $note
	 * @return Rating
	 */
	public function setNote($note)
	{
		$this->note = $note;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param string $type
	 * @return Rating
	 */
	public function setType($type)
	{
		$this->type = $type;

		return $this;
	}
}