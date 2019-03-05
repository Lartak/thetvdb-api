<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 09:27
 */

namespace TheTvDb\Model\Common;

/**
 * Class ResultCollection
 *
 * @package TheTvDb\Model\Common
 */
class ResultCollection extends GenericCollection
{
	/**
	 * @var \TheTvDb\Model\Series\Pagination
	 */
	private $pagination;

	/**
	 * @var array
	 */
	public static $properties = [
		'pagination'
	];

	/**
	 * @return \TheTvDb\Model\Series\Pagination
	 */
	public function getPagination()
	{
		return $this->pagination;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $pagination
	 * @return ResultCollection
	 */
	public function setPagination($pagination)
	{
		$this->pagination = $pagination;

		return $this;
	}
}