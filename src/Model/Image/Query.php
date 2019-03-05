<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/03/2019
 * Time: 18:44
 */

namespace TheTvDb\Model\Image;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Series\RatingsInfo;

/**
 * Class Query
 *
 * @package TheTvDb\Model\Image
 */
class Query extends AbstractModel
{
	const REGEX = "/^([a-z:]+[\/]{2})([w]{3}.[a-z]{7}.[a-z]{3})/";
	const BASE_URI = 'https://www.thetvdb.com/banners/';
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $fileName;
	/**
	 * @var string
	 */
	private $keyType;
	/**
	 * @var int
	 */
	private $languageId;
	/**
	 * @var \TheTvDb\Model\Series\RatingsInfo
	 */
	private $ratingsInfo;
	/**
	 * @var \TheTvDb\Model\Image\Resolution
	 */
	private $resolution;
	/**
	 * @var string
	 */
	private $subKey;
	/**
	 * @var string
	 */
	private $thumbnail;
	/**
	 * @var array
	 */
	public static $properties = [
		'id', 'keyType', 'subKey', 'fileName', 'languageId', 'resolution', 'ratingsInfo', 'thumbnail'
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
	 * @return Query
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getFileName()
	{
		return $this->fileName;
	}

	/**
	 * @param string $fileName
	 * @return Query
	 */
	public function setFileName($fileName)
	{
		if (!preg_match(self::REGEX, $fileName)) {
			$fileName = self::BASE_URI . $fileName;
		}
		$this->fileName = $fileName;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getKeyType()
	{
		return $this->keyType;
	}

	/**
	 * @param string $keyType
	 * @return Query
	 */
	public function setKeyType($keyType)
	{
		$this->keyType = $keyType;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getLanguageId()
	{
		return $this->languageId;
	}

	/**
	 * @param int $languageId
	 * @return Query
	 */
	public function setLanguageId($languageId)
	{
		$this->languageId = $languageId;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Series\RatingsInfo
	 */
	public function getRatingsInfo()
	{
		return $this->ratingsInfo;
	}

	/**
	 * @param \TheTvDb\Model\Series\RatingsInfo $ratingsInfo
	 * @return Query
	 */
	public function setRatingsInfo($ratingsInfo)
	{
		if (!$ratingsInfo instanceof RatingsInfo) {
			$ratingsInfo = (new \TheTvDb\Common\ObjectHydrater())
				->hydrate(
					new RatingsInfo(),
					$ratingsInfo
				);
		}
		$this->ratingsInfo = $ratingsInfo;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Image\Resolution
	 */
	public function getResolution()
	{
		return $this->resolution;
	}

	/**
	 * @param \TheTvDb\Model\Image\Resolution $resolution
	 * @return Query
	 */
	public function setResolution($resolution)
	{
		if (!$resolution instanceof \TheTvDb\Model\Image\Resolution) {
			$resolution = (new \TheTvDb\Common\ObjectHydrater())
				->hydrate(
					new \TheTvDb\Model\Image\Resolution(),
					$resolution
				);
		}
		$this->resolution = $resolution;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getSubKey()
	{
		return $this->subKey;
	}

	/**
	 * @param string $subKey
	 * @return Query
	 */
	public function setSubKey($subKey)
	{
		$this->subKey = $subKey;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getThumbnail()
	{
		return $this->thumbnail;
	}

	/**
	 * @param string $thumbnail
	 * @return Query
	 */
	public function setThumbnail($thumbnail)
	{
		if (!preg_match(self::REGEX, $thumbnail)) {
			$thumbnail = self::BASE_URI . $thumbnail;
		}
		$this->thumbnail = $thumbnail;

		return $this;
	}
}