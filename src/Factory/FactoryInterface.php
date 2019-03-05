<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 09:21
 */

namespace TheTvDb\Factory;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\GenericCollection;

/**
 * Interface FactoryInterface
 *
 * @category TheTvDb
 * @package TheTvDb\Factory
 * @author Lartak
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface FactoryInterface
{
	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel
	 */
	public function create(array $data = []);
	/**
	 * Convert an array with an collection of items to an hydrated object collection
	 *
	 * @param  array             $data
	 * @return GenericCollection
	 */
	public function createCollection(array $data = []);
}