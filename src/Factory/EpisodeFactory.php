<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 10:41
 */

namespace TheTvDb\Factory;

use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Collection\EpisodesCollection;
use TheTvDb\Model\Collection\FavoritesCollection;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Episode;

/**
 * Class EpisodeFactory
 *
 * @package TheTvDb\Factory
 */
class EpisodeFactory extends AbstractFactory
{
	/**
	 * EpisodeFactory constructor.
	 *
	 * @param \TheTvDb\Http\HttpClient $httpClient
	 */
	public function __construct(\TheTvDb\Http\HttpClient $httpClient)
	{
		parent::__construct($httpClient);
	}

	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel
	 */
	public function create(array $data = [])
	{
		$episode = new Episode();
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$episode
			->setId($data['id'])
			->setName($data['episodeName'])
			->setOverview($data['overview'])
			->setAbsoluteNumber($data['absoluteNumber'])
			->setAired($this->hydrate(new Episode\Aired(), [
				'episodeNumber' => $data['airedEpisodeNumber'],
				'season' => $this->hydrate(new Episode\AiredSeason(), [
					'id'        =>  $data['airedSeasonID'],
					'number'    =>  $data['airedSeason']
				])
			]))
			->setAirs($this->hydrate(new Episode\Airs(), [
				'afterSeason'   =>  $data['airsAfterSeason'],
				'beforeEpisode' =>  $data['airsBeforeEpisode'],
				'beforeSeason'  =>  $data['airsBeforeSeason']])
			)
			->setSeriesId($data['seriesId'])
			->setDirector($data['director'])
			->setDirectors($data['directors'])
			->setDvd($this->hydrate(new Episode\Dvd(), [
				'chapter'       =>  $data['dvdChapter'],
				'discId'        =>  $data['dvdDiscid'],
				'episodeNumber' =>  $data['dvdEpisodeNumber'],
				'season'        =>  $data['dvdSeason']
			]))
			->setFilename($data['filename'])
			->setFirstAired($data['firstAired'])
			->setGuestStars($data['guestStars'])
			->setSite($this->hydrate(new Episode\Site(), [
				'rating'        =>  $data['siteRating'],
				'ratingCount'   =>  $data['siteRatingCount']
			]))
			->setThumb($this->hydrate(new Episode\Thumb(), [
				'added'     =>  $data['thumbAdded'],
				'author'    =>  $data['thumbAuthor'],
				'height'    =>  $data['thumbHeight'],
				'width'     =>  $data['thumbWidth']
			]))
			->setExternalIds($this->hydrate(new Episode\ExternalIds(), [
				'imDb'  =>  $data['imdbId']
			]))
			->setLanguage($this->hydrate(new Episode\Language(), $data['language']))
			->setLastUpdated($data['lastUpdated'])
			->setLastUpdatedBy($data['lastUpdatedBy'])
			->setProductionCode($data['productionCode'])
			->setShowUrl($data['showUrl'])
			->setWriters($data['writers']);
		return $this->hydrate($episode);
	}

	/**
	 * Convert an array with an collection of items to an hydrated object collection
	 *
	 * @param  array $data
	 * @return GenericCollection
	 */
	public function createCollection(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$collection = new GenericCollection();
		foreach ($data as $episode)
		{
			$collection->add(null, $this->create($episode));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Collection\EpisodesCollection
	 */
	public function createEpisodesCollection(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$collection = new EpisodesCollection();
		foreach ($data as $episode)
		{
			$collection->add(null, $this->create($episode));
		}
		return $collection;
	}

	/**
	 * @param $displayMode
	 * @param array $data
	 * @return \TheTvDb\Model\Collection\FavoritesCollection
	 */
	public function createFavoritesCollection($displayMode, array $data = [])
	{
		$collection = new FavoritesCollection();
		foreach ($data as $favorite)
		{
			$collection->add(null, $this->create($favorite));
		}
		$collection->setDisplayMode($displayMode);
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\ResultCollection
	 */
	public function createResultEpisodesCollection(array $data)
	{
		if (array_key_exists('data', $data))
		{
			$data['results'] = $data['data'];
		}
		$data['current'] = $data['page'];
		$data = array_merge($data, $data['links']);
		return parent::createResultCollection($data);
	}
}