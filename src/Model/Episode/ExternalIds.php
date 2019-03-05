<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 10:22
 */

namespace TheTvDb\Model\Episode;


use TheTvDb\Model\AbstractModel;

/**
 * Class ExternalIds
 *
 * @package TheTvDb\Model\Episode
 */
class ExternalIds extends AbstractModel
{
	/**
	 * @var string|null
	 */
	private $imDb;
	/**
	 * @var array
	 */
	public static $properties = [
		'imDb'
	];

	/**
	 * @return string|null
	 */
	public function getImDb()
	{
		return $this->imDb;
	}

	/**
	 * @param string $imDb
	 * @return ExternalIds
	 */
	public function setImDb($imDb)
	{
		$this->imDb = strlen($imDb) ? $imDb : null;

		return $this;
	}
}