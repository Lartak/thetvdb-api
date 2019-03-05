<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 07/01/2019
 * Time: 14:54
 */

namespace TheTvDb\Model\Series;


use TheTvDb\Model\AbstractModel;

/**
 * Class Summary
 *
 * @package TheTvDb\Model\Series
 */
class Summary extends AbstractModel
{
	/**
	 * @var \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	private $airedSeasons;
	/**
	 * @var integer
	 */
	private $airedEpisodes;
	/**
	 * @var \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	private $dvdSeasons;
	/**
	 * @var integer
	 */
	private $dvdEpisodes;
	/**
	 * @var array
	 */
	public static $properties= [
		'airedSeasons', 'airedEpisodes', 'dvdSeasons', 'dvdEpisodes'
	];

	/**
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function getAiredSeasons()
	{
		return $this->airedSeasons;
	}

	/**
	 * @param \TheTvDb\Model\Common\CollectionToCommaSeparatedString $airedSeasons
	 * @return Summary
	 */
	public function setAiredSeasons($airedSeasons)
	{
		$this->airedSeasons = $airedSeasons;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAiredEpisodes()
	{
		return $this->airedEpisodes;
	}

	/**
	 * @param int|string $airedEpisodes
	 * @return Summary
	 */
	public function setAiredEpisodes($airedEpisodes)
	{
		$this->airedEpisodes = is_string($airedEpisodes) ? (int)$airedEpisodes : $airedEpisodes;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function getDvdSeasons()
	{
		return $this->dvdSeasons;
	}

	/**
	 * @param \TheTvDb\Model\Common\CollectionToCommaSeparatedString $dvdSeasons
	 * @return Summary
	 */
	public function setDvdSeasons($dvdSeasons)
	{
		$this->dvdSeasons = $dvdSeasons;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDvdEpisodes()
	{
		return $this->dvdEpisodes;
	}

	/**
	 * @param int|string $dvdEpisodes
	 * @return Summary
	 */
	public function setDvdEpisodes($dvdEpisodes)
	{
		$this->dvdEpisodes = is_string($dvdEpisodes) ? (int)$dvdEpisodes : $dvdEpisodes;

		return $this;
	}
}