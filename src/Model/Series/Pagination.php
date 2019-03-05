<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/03/2019
 * Time: 02:31
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Pagination
 *
 * @package TheTvDb\Model\Series
 */
class Pagination extends AbstractModel
{
	/**
	 * @var int
	 */
	private $current = 1;

	/**
	 * @var int
	 */
	private $first;

	/**
	 * @var int
	 */
	private $prev;

	/**
	 * @var int
	 */
	private $next;

	/**
	 * @var int
	 */
	private $last;

	/**
	 * @var array
	 */
	public static $properties = [
		'current', 'first', 'prev', 'next', 'last'
	];

	/**
	 * @return int
	 */
	public function getCurrent()
	{
		return $this->current;
	}

	/**
	 * @param int $current
	 * @return Pagination
	 */
	public function setCurrent($current)
	{
		$this->current = $current;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getFirst()
	{
		return $this->first;
	}

	/**
	 * @param int $first
	 * @return Pagination
	 */
	public function setFirst($first)
	{
		$this->first = $first;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPrev()
	{
		return $this->prev;
	}

	/**
	 * @param int $prev
	 * @return Pagination
	 */
	public function setPrev($prev)
	{
		$this->prev = $prev;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getNext()
	{
		return $this->next;
	}

	/**
	 * @param int $next
	 * @return Pagination
	 */
	public function setNext($next)
	{
		$this->next = $next;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLast()
	{
		return $this->last;
	}

	/**
	 * @param int $last
	 * @return Pagination
	 */
	public function setLast($last)
	{
		$this->last = $last;

		return $this;
	}
}