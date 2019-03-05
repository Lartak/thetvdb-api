<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 01:06
 */

namespace TheTvDb\Model;


/**
 * Class Series
 *
 * @package TheTvDb\Model
 */
class Series extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var \TheTvDb\Model\Common\GenericCollection|null
	 */
	private $actors;
	/**
	 * @var string
	 */
	private $seriesName;
	/**
	 * @var string[]
	 */
	private $aliases;
	/**
	 * @var string
	 */
	private $banner;
	/**
	 * @var \TheTvDb\Model\Series\Image|null
	 */
	private $images;
	/**
	 * @var string
	 */
	private $seriesId;
	/**
	 * @var string
	 */
	private $status;
	/**
	 * @var \DateTime
	 */
	private $firstAired;
	/**
	 * @var \TheTvDb\Model\Network
	 */
	private $network;
	/**
	 * @var integer
	 */
	private $runtime;
	/**
	 * @var string[]
	 */
	private $genre;
	/**
	 * @var string
	 */
	private $overview;
	/**
	 * @var \DateTime
	 */
	private $lastUpdated;
	/**
	 * @var string
	 */
	private $airsDayOfWeek;
	/**
	 * @var string
	 */
	private $airsTime;
	/**
	 * @var \TheTvDb\Model\Series\ExternalIds
	 */
	private $externalIds;
	/**
	 * @var string|null
	 */
	private $added;
	/**
	 * @var string|null
	 */
	private $addedBy;
	/**
	 * @var \TheTvDb\Model\Episode\Site
	 */
	private $site;
	/**
	 * @var \TheTvDb\Model\Common\ResultCollection|null
	 */
	private $episodes;
	/**
	 * @var string
	 */
	private $rating;
	/**
	 * @var string
	 */
	private $slug;
	/**
	 * @var \TheTvDb\Model\Series\Summary|null
	 */
	private $summary;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'seriesName', 'aliases', 'banner', 'seriesId', 'status', 'firstAired', 'network', 'runtime', 'slug',
		'genre', 'overview', 'lastUpdated', 'airsDayOfWeek', 'airsTime', 'externalIds', 'added', 'addedBy', 'site',
		'images', 'actors', 'episodes', 'rating', 'summary'
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
	 * @return Series
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Common\GenericCollection|null
	 */
	public function getActors()
	{
		return $this->actors;
	}

	/**
	 * @param \TheTvDb\Model\Common\GenericCollection|null $actors
	 * @return Series
	 */
	public function setActors($actors)
	{
		$this->actors = $actors;

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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
	 */
	public function setBanner($banner)
	{
		$this->banner = $banner;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Series\Image|null
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param \TheTvDb\Model\Series\Image|null $images
	 * @return Series
	 */
	public function setImages($images)
	{
		$this->images = $images;

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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
	 */
	public function setRuntime($runtime)
	{
		$this->runtime = $runtime;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getGenre()
	{
		return $this->genre;
	}

	/**
	 * @param string[] $genre
	 * @return Series
	 */
	public function setGenre($genre)
	{
		$this->genre = $genre;

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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
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
	 * @return Series
	 */
	public function setSite($site)
	{
		$this->site = $site;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Common\ResultCollection|null
	 */
	public function getEpisodes()
	{
		return $this->episodes;
	}

	/**
	 * @param \TheTvDb\Model\Common\ResultCollection|null $episodes
	 * @return Series
	 */
	public function setEpisodes($episodes)
	{
		$this->episodes = $episodes;

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
	 * @return Series
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
	 * @return Series
	 */
	public function setSlug($slug)
	{
		$this->slug = $slug;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Series\Summary|null
	 */
	public function getSummary()
	{
		return $this->summary;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel|null $summary
	 * @return Series
	 */
	public function setSummary($summary)
	{
		$this->summary = $summary;

		return $this;
	}
}