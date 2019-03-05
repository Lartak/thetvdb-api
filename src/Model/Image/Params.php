<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 18:44
 */

namespace TheTvDb\Model\Image;


use TheTvDb\Common\ObjectHydrater;
use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\GenericCollection;

/**
 * Class Params
 *
 * @package TheTvDb\Model\Image
 */
class Params extends AbstractModel
{
	/**
	 * @var string
	 */
	private $keyType;
	/**
	 * @var GenericCollection
	 */
	private $resolutions;
	/**
	 * @var array
	 */
	private $subKeys;
	/**
	 * @var array
	 */
	public static $properties = [
		'keyType', 'resolutions', 'subKeys'
	];

	/**
	 * @return string
	 */
	public function getKeyType()
	{
		return $this->keyType;
	}

	/**
	 * @param string $keyType
	 * @return Params
	 */
	public function setKeyType($keyType)
	{
		$this->keyType = $keyType;

		return $this;
	}

	/**
	 * @return GenericCollection
	 */
	public function getResolutions()
	{
		return $this->resolutions;
	}

	/**
	 * @param GenericCollection|array $resolutions
	 * @return Params
	 */
	public function setResolutions($resolutions)
	{
		if (!$resolutions instanceof GenericCollection) {
			$collection = new GenericCollection();
			foreach ($resolutions as $resolution)
			{
				$resolution = explode('x', $resolution);
				$resolution = (new ObjectHydrater())->hydrate(new Resolution(), [
					'height'    =>  $resolution[1],
					'width'     =>  $resolution[0]
				]);
				$collection->add(null, $resolution);
			}
			$resolutions = $collection;
		}
		$this->resolutions = $resolutions;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getSubKeys()
	{
		return $this->subKeys;
	}

	/**
	 * @param array $subKeys
	 * @return Params
	 */
	public function setSubKeys($subKeys)
	{
		$this->subKeys = $subKeys;

		return $this;
	}
}