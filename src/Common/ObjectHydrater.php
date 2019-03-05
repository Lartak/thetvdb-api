<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 01:00
 */

namespace TheTvDb\Common;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Exception\RuntimeException;

/**
 * Utilisation class to hydrate objects.
 *
 * Class ObjectHydrater
 *
 * @package TheTvDb\Common
 */
class ObjectHydrater
{
	/**
	 * Hydrate the object with data
	 *
	 * @param  AbstractModel $object
	 * @param  array $data
	 * @return AbstractModel
	 * @throws RuntimeException
	 */
	public function hydrate(AbstractModel $object, $data = [])
	{
		if (!empty($data)) {
			foreach ($data as $k => $v) {
				if (in_array($k, $object::$properties)) {
					$method = $this->camelize(
						sprintf('set_%s', $k)
					);
					if (!is_callable([$object, $method])) {
						throw new RuntimeException(sprintf(
							'Trying to call method "%s" on "%s" but it does not exist or is private.',
							$method,
							get_class($object)
						));
					} else {
						$object->$method($v);
					}
				}
			}
		}
		return $object;
	}
	/**
	 * Transforms an under_scored_string to a camelCasedOne
	 *
	 * @see https://gist.github.com/troelskn/751517
	 *
	 * @param  string $candidate
	 * @return string
	 */
	public function camelize($candidate)
	{
		return lcfirst(
			implode(
				'',
				array_map(
					'ucfirst',
					array_map(
						'strtolower',
						explode(
							'_',
							$candidate
						)
					)
				)
			)
		);
	}

}