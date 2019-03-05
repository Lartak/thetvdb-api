<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 21:29
 */

namespace TheTvDb\Factory;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Language;

/**
 * Class LanguageFactory
 *
 * @package TheTvDb\Factory
 */
class LanguageFactory extends AbstractFactory
{

	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel|Language
	 */
	public function create(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		return $this->hydrate(new Language(), $data);
	}

	/**
	 * Convert an array with an collection of items to an hydrated object collection
	 *
	 * @param  array $data
	 * @return GenericCollection
	 */
	public function createCollection(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		return parent::createGenericCollection(new Language(), $data);
	}
}