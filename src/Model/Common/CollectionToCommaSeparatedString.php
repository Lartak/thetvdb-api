<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 07/01/2019
 * Time: 14:59
 */

namespace TheTvDb\Model\Common;


/**
 * Class CollectionToCommaSeparatedString
 *
 * @package TheTvDb\Model\Common
 */
class CollectionToCommaSeparatedString extends GenericCollection
{

	/**
	 * @param array $collection
	 */
	public function __construct(array $collection = [])
	{
		parent::__construct($data = []);
		$i = 0;
		foreach ($collection as $item)
		{
			$this->add($i, $item);
			$i++;
		}
	}

	/**
	 * @return string
	 */
	public function getValue()
	{
		return implode(',', $this->data);
	}
}