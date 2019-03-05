<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:39
 */

namespace TheTvDb\Model\Collection;


use TheTvDb\Model\Common\GenericCollection;

/**
 * Class FavoritesCollection
 *
 * @package TheTvDb\Model\Collection
 */
class FavoritesCollection extends GenericCollection
{
	/**
	 * @var string
	 */
	private $displayMode;
	/**
	 * @var array
	 */
	public static $properties = [
		'display_mode'
	];

	/**
	 * @return string
	 */
	public function getDisplayMode()
	{
		return $this->displayMode;
	}

	/**
	 * @param string $displayMode
	 * @return FavoritesCollection
	 */
	public function setDisplayMode($displayMode)
	{
		$this->displayMode = $displayMode;

		return $this;
	}
}