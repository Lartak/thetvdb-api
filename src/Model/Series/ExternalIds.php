<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 01:25
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class ExternalIds
 *
 * @package TheTvDb\Model\Series
 */
class ExternalIds extends AbstractModel
{
	/**
	 * @var string
	 */
	private $imdbId;
	/**
	 * @var string|null
	 */
	private $zap2itId;
	/**
	 * @var array
	 */
	public static $properties = [
		'imdbId', 'zap2itId'
	];

	/**
	 * @return string
	 */
	public function getImdbId()
	{
		return $this->imdbId;
	}

	/**
	 * @param string $imdbId
	 * @return ExternalIds
	 */
	public function setImdbId($imdbId)
	{
		$this->imdbId = $imdbId;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getZap2itId()
	{
		return $this->zap2itId;
	}

	/**
	 * @param string $zap2itId
	 * @return ExternalIds
	 */
	public function setZap2itId($zap2itId)
	{
		$this->zap2itId = strlen($zap2itId) ? $zap2itId : null;

		return $this;
	}
}