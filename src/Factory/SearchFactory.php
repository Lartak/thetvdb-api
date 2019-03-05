<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 04:52
 */

namespace TheTvDb\Factory;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Series\Search;

/**
 * Class SearchFactory
 *
 * @package TheTvDb\Factory
 */
class SearchFactory extends AbstractFactory
{

	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel
	 */
	public function create(array $data = [])
	{
		$data['name'] = $data['seriesName'];
		return $this->hydrate(new Search(), $data);
	}

	/**
	 * Convert an array with an collection of items to an hydrated object collection
	 *
	 * @param  array $data
	 * @return \TheTvDb\Model\AbstractModel|\TheTvDb\Model\Common\GenericCollection
	 */
	public function createCollection(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (count($data) === 1) {
			if (array_key_exists(0, $data)) {
				$data = $data[0];
			}
			return $this->create($data);
		}
		$collection = new GenericCollection();
		foreach ($data as $item)
		{
			$collection->add(null, $this->create($item));
		}
		return $collection;
	}
}