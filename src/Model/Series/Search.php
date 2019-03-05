<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 04:44
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Search
 *
 * @package TheTvDb\Model\Series
 */
class Search extends AbstractModel
{
	/**
	 * @var array
	 */
	private $aliases;
	/**
	 * @var string
	 */
	private $banner;
	/**
	 * @var \DateTime
	 */
	private $firstAired;
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $network;
	/**
	 * @var string
	 */
	private $overview;
	/**
	 * @var string
	 */
	private $slug;
	/**
	 * @var string
	 */
	private $status;
	/**
	 * @var array
	 */
	public static $properties = [
		'aliases', 'banner', 'firstAired', 'id', 'name', 'network', 'network', 'overview', 'slug', 'status'
	];

	/**
	 * @return array
	 */
	public function getAliases()
	{
		return $this->aliases;
	}

	/**
	 * @param array $aliases
	 * @return Search
	 */
	public function setAliases($aliases)
	{
		$this->aliases = $aliases;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBanner()
	{
		return $this->banner;
	}

	/**
	 * @param string $banner
	 * @return Search
	 */
	public function setBanner($banner)
	{
		$this->banner = $banner;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getFirstAired()
	{
		return $this->firstAired;
	}

	/**
	 * @param \DateTime $firstAired
	 * @return Search
	 * @throws \Exception
	 */
	public function setFirstAired($firstAired)
	{
		$this->firstAired = new \DateTime($firstAired);

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Search
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return Search
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getNetwork()
	{
		return $this->network;
	}

	/**
	 * @param string $network
	 * @return Search
	 */
	public function setNetwork($network)
	{
		$this->network = $network;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getOverview()
	{
		return $this->overview;
	}

	/**
	 * @param string $overview
	 * @return Search
	 */
	public function setOverview($overview)
	{
		$this->overview = $overview;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSlug()
	{
		return $this->slug;
	}

	/**
	 * @param string $slug
	 * @return Search
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}

	/**
	 * @param string $status
	 * @return Search
	 */
	public function setStatus($status)
	{
		$this->status = $status;

		return $this;
	}
}