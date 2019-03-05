<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 01:06
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Filter
 *
 * @package TheTvDb\Model
 */
class Filter extends AbstractModel
{
	/**
	 * @var string|null
	 */
	private $added;
	/**
	 * @var string|null
	 */
	private $addedBy;
	/**
	 * @var string
	 */
	private $airsDayOfWeek;
	/**
	 * @var string
	 */
	private $airsTime;
	/**
	 * @var string[]
	 */
	private $aliases;
	/**
	 * @var string
	 */
	private $banner;
	/**
	 * @var \TheTvDb\Model\Series\ExternalIds
	 */
	private $externalIds;
	/**
	 * @var \DateTime
	 */
	private $firstAired;
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var \DateTime
	 */
	private $lastUpdated;
	/**
	 * @var \TheTvDb\Model\Network
	 */
	private $network;
	/**
	 * @var string
	 */
	private $overview;
	/**
	 * @var string
	 */
	private $rating;
	/**
	 * @var integer
	 */
	private $runtime;
	/**
	 * @var string
	 */
	private $seriesId;
	/**
	 * @var string
	 */
	private $seriesName;
	/**
	 * @var \TheTvDb\Model\Episode\Site
	 */
	private $site;
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
		'id', 'seriesName', 'aliases', 'banner', 'seriesId', 'status', 'firstAired', 'network', 'runtime', 'slug',
		'overview', 'lastUpdated', 'airsDayOfWeek', 'airsTime', 'externalIds', 'added', 'addedBy', 'site',
		'rating'
	];

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return Filter
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSeriesName()
	{
		return $this->seriesName;
	}

	/**
	 * @param string $seriesName
	 * @return Filter
	 */
	public function setSeriesName($seriesName)
	{
		$this->seriesName = $seriesName;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getAliases()
	{
		return $this->aliases;
	}

	/**
	 * @param string[] $aliases
	 * @return Filter
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
	 * @return Filter
	 */
	public function setBanner($banner)
	{
		$this->banner = $banner;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSeriesId()
	{
		return $this->seriesId;
	}

	/**
	 * @param string $seriesId
	 * @return Filter
	 */
	public function setSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;

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
	 * @return Filter
	 */
	public function setStatus($status)
	{
		$this->status = $status;

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
	 * @param \DateTime|string $firstAired
	 * @return Filter
	 * @throws \Exception
	 */
	public function setFirstAired($firstAired)
	{
		if (!$firstAired instanceof \DateTime) {
			$firstAired = new \DateTime($firstAired);
		}
		$this->firstAired = $firstAired;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Network
	 */
	public function getNetwork()
	{
		return $this->network;
	}

	/**
	 * @param \TheTvDb\Model\Network|\TheTvDb\Model\AbstractModel $network
	 * @return Filter
	 */
	public function setNetwork($network)
	{
		$this->network = $network;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getRuntime()
	{
		return $this->runtime;
	}

	/**
	 * @param int $runtime
	 * @return Filter
	 */
	public function setRuntime($runtime)
	{
		$this->runtime = $runtime;

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
	 * @return Filter
	 */
	public function setOverview($overview)
	{
		$this->overview = $overview;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * @param integer $lastUpdated
	 * @return Filter
	 * @throws \Exception
	 */
	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = (new \DateTime())->setTimestamp($lastUpdated);

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAirsDayOfWeek()
	{
		return $this->airsDayOfWeek;
	}

	/**
	 * @param string $airsDayOfWeek
	 * @return Filter
	 */
	public function setAirsDayOfWeek($airsDayOfWeek)
	{
		$this->airsDayOfWeek = $airsDayOfWeek;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getAirsTime()
	{
		return $this->airsTime;
	}

	/**
	 * @param string $airsTime
	 * @return Filter
	 */
	public function setAirsTime($airsTime)
	{
		$this->airsTime = $airsTime;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Series\ExternalIds
	 */
	public function getExternalIds()
	{
		return $this->externalIds;
	}

	/**
	 * @param \TheTvDb\Model\Series\ExternalIds|\TheTvDb\Model\AbstractModel $externalIds
	 * @return Filter
	 */
	public function setExternalIds($externalIds)
	{
		$this->externalIds = $externalIds;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAdded()
	{
		return $this->added;
	}

	/**
	 * @param string $added
	 * @return Filter
	 */
	public function setAdded($added)
	{
		$this->added = strlen($added) ? $added : null;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getAddedBy()
	{
		return $this->addedBy;
	}

	/**
	 * @param string|null $addedBy
	 * @return Filter
	 */
	public function setAddedBy($addedBy)
	{
		if (!is_null($addedBy)) {
			$addedBy = strlen($addedBy) ? $addedBy : null;
		}
		$this->addedBy = $addedBy;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Site
	 */
	public function getSite()
	{
		return $this->site;
	}

	/**
	 * @param \TheTvDb\Model\Episode\Site|\TheTvDb\Model\AbstractModel $site
	 * @return Filter
	 */
	public function setSite($site)
	{
		$this->site = $site;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRating()
	{
		return $this->rating;
	}

	/**
	 * @param string $rating
	 * @return Filter
	 */
	public function setRating($rating)
	{
		$this->rating = $rating;

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
	 * @return Filter
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}
}