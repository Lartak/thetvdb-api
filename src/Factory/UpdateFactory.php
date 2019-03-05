<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 15:01
 */

namespace TheTvDb\Factory;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Update;

/**
 * Class UpdateFactory
 *
 * @package TheTvDb\Factory
 */
class UpdateFactory extends AbstractFactory
{

	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel
	 */
	public function create(array $data = [])
	{
		return $this->hydrate(new Update(), $data);
	}

	/**
	 * Convert an array with an collection of items to an hydrated object collection
	 *
	 * @param  array $data
	 * @return GenericCollection
	 */
	public function createCollection(array $data = [])
	{
		$collection = new GenericCollection();
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		foreach ($data as $item)
		{
			$collection->add(null, $this->create($item));
		}
		return $collection;
	}
}