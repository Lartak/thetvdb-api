<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 09:43
 */

namespace TheTvDb\Model;


/**
 * Class Episode
 *
 * @package TheTvDb\Model
 */
class Episode extends AbstractModel
{
	/**
	 * @var integer
	 */
	private $id;
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string|null
	 */
	private $overview;
	/**
	 * @var integer
	 */
	private $absoluteNumber;
	/**
	 * @var \TheTvDb\Model\Episode\Aired
	 */
	private $aired;
	/**
	 * @var \TheTvDb\Model\Episode\Airs
	 */
	private $airs;
	/**
	 * @var integer
	 */
	private $seriesId;
	/**
	 * @var string
	 */
	private $director;
	/**
	 * @var string[]
	 */
	private $directors;
	/**
	 * @var \TheTvDb\Model\Episode\Dvd
	 */
	private $dvd;
	/**
	 * @var string
	 */
	private $filename;
	/**
	 * @var string
	 */
	private $firstAired;
	/**
	 * @var string[]
	 */
	private $guestStars;
	/**
	 * @var \TheTvDb\Model\Episode\Site
	 */
	private $site;
	/**
	 * @var \TheTvDb\Model\Episode\Thumb
	 */
	private $thumb;
	/**
	 * @var \TheTvDb\Model\Episode\ExternalIds
	 */
	private $externalIds;
	/**
	 * @var \TheTvDb\Model\Episode\Language
	 */
	private $language;
	/**
	 * @var integer
	 */
	private $lastUpdated;
	/**
	 * @var integer
	 */
	private $lastUpdatedBy;
	/**
	 * @var string|null
	 */
	private $productionCode;
	/**
	 * @var string|null
	 */
	private $showUrl;
	/**
	 * @var string[]
	 */
	private $writers;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'overview', 'absoluteNumber', 'seriesId', 'director', 'directors', 'filename',
		'firstAired', 'guestStars', 'lastUpdated', 'lastUpdatedBy', 'showUrl', 'writers'
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
	 * @return Episode
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
	 * @return Episode
	 */
	public function setName($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getOverview()
	{
		return $this->overview;
	}

	/**
	 * @param string $overview
	 * @return Episode
	 */
	public function setOverview($overview)
	{
		$this->overview = strlen($overview) ? $overview : null;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAbsoluteNumber()
	{
		return $this->absoluteNumber;
	}

	/**
	 * @param int $absoluteNumber
	 * @return Episode
	 */
	public function setAbsoluteNumber($absoluteNumber)
	{
		$this->absoluteNumber = $absoluteNumber;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Aired
	 */
	public function getAired()
	{
		return $this->aired;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $aired
	 * @return Episode
	 */
	public function setAired($aired)
	{
		$this->aired = $aired;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Airs
	 */
	public function getAirs()
	{
		return $this->airs;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $airs
	 * @return Episode
	 */
	public function setAirs($airs)
	{
		$this->airs = $airs;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSeriesId()
	{
		return $this->seriesId;
	}

	/**
	 * @param int $seriesId
	 * @return Episode
	 */
	public function setSeriesId($seriesId)
	{
		$this->seriesId = $seriesId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDirector()
	{
		return $this->director;
	}

	/**
	 * @param string $director
	 * @return Episode
	 */
	public function setDirector($director)
	{
		$this->director = $director;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getDirectors()
	{
		return $this->directors;
	}

	/**
	 * @param string[] $directors
	 * @return Episode
	 */
	public function setDirectors($directors)
	{
		$this->directors = $directors;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Dvd
	 */
	public function getDvd()
	{
		return $this->dvd;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $dvd
	 * @return Episode
	 */
	public function setDvd($dvd)
	{
		$this->dvd = $dvd;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFilename()
	{
		return $this->filename;
	}

	/**
	 * @param string $filename
	 * @return Episode
	 */
	public function setFilename($filename)
	{
		$this->filename = strlen($filename) ? $filename : null;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFirstAired()
	{
		return $this->firstAired;
	}

	/**
	 * @param string $firstAired
	 * @return Episode
	 */
	public function setFirstAired($firstAired)
	{
		$this->firstAired = $firstAired;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getGuestStars()
	{
		return $this->guestStars;
	}

	/**
	 * @param string[] $guestStars
	 * @return Episode
	 */
	public function setGuestStars($guestStars)
	{
		$this->guestStars = $guestStars;

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
	 * @param \TheTvDb\Model\AbstractModel $site
	 * @return Episode
	 */
	public function setSite($site)
	{
		$this->site = $site;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Thumb
	 */
	public function getThumb()
	{
		return $this->thumb;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $thumb
	 * @return Episode
	 */
	public function setThumb($thumb)
	{
		$this->thumb = $thumb;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\ExternalIds
	 */
	public function getExternalIds()
	{
		return $this->externalIds;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $externalIds
	 * @return Episode
	 */
	public function setExternalIds($externalIds)
	{
		$this->externalIds = $externalIds;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Episode\Language
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param \TheTvDb\Model\AbstractModel $language
	 * @return Episode
	 */
	public function setLanguage($language)
	{
		$this->language = $language;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLastUpdated()
	{
		return $this->lastUpdated;
	}

	/**
	 * @param int $lastUpdated
	 * @return Episode
	 */
	public function setLastUpdated($lastUpdated)
	{
		$this->lastUpdated = $lastUpdated;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLastUpdatedBy()
	{
		return $this->lastUpdatedBy;
	}

	/**
	 * @param string $lastUpdatedBy
	 * @return Episode
	 */
	public function setLastUpdatedBy($lastUpdatedBy)
	{
		$this->lastUpdatedBy = $lastUpdatedBy;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getProductionCode()
	{
		return $this->productionCode;
	}

	/**
	 * @param string $productionCode
	 * @return Episode
	 */
	public function setProductionCode($productionCode)
	{
		$this->productionCode = strlen($productionCode) ? $productionCode : null;

		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getShowUrl()
	{
		return $this->showUrl;
	}

	/**
	 * @param string $showUrl
	 * @return Episode
	 */
	public function setShowUrl($showUrl)
	{
		$this->showUrl = strlen($showUrl) ? $showUrl : null;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function getWriters()
	{
		return $this->writers;
	}

	/**
	 * @param string[] $writers
	 * @return Episode
	 */
	public function setWriters($writers)
	{
		$this->writers = $writers;

		return $this;
	}
}