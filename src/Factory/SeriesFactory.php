<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 00:59
 */

namespace TheTvDb\Factory;


use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Collection\FavoritesCollection;
use TheTvDb\Model\Common\CollectionToCommaSeparatedString;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Episode\Site;
use TheTvDb\Model\Image\Params;
use TheTvDb\Model\Network;
use TheTvDb\Model\Rating;
use TheTvDb\Model\Series;
use TheTvDb\Model\Series\ExternalIds;
use TheTvDb\Model\Image\Resolution;
use TheTvDb\Model\Image\Query;

/**
 * Class SeriesFactory
 *
 * @package TheTvDb\Factory
 */
class SeriesFactory extends AbstractFactory
{

	/**
	 * Convert an array to an hydrated object
	 *
	 * @param  array $data
	 * @return AbstractModel
	 */
	public function create(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (!empty($data['externalIds']) || (!empty($data['imdbId']) || !empty($data['zap2itId']))) {
			if (!empty($data['imdbId'])) {
				$data['externalIds']['imdbId'] = $data['imdbId'];
			}
			if (!empty($data['zap2itId'])) {
				$data['externalIds']['zap2itId'] = $data['zap2itId'];
			}
			$data['externalIds'] = $this->hydrate(new ExternalIds(), $data);
		}
		if (!empty($data['site']) || (!empty($data['siteRating']) || !empty($data['siteRatingCount']))) {
			$data['site'] = $this->hydrate(new Site(), [
				'rating'        =>  $data['siteRating'],
				'ratingCount'   =>  $data['siteRatingCount']
			]);
		}
		if (!empty($data['network'])) {
			$data['network'] = $this->hydrate(new Network(), [
				'id'    =>  $data['networkId'],
				'name'  =>  $data['network']
			]);
		}
		if (!empty($data['actors']) && !$data['actors'] instanceof GenericCollection) {
			$data['actors'] = $this->createActorsCollection($data['actors']);
		}
		if (!empty($data['images']) && !$data['images'] instanceof Series\Image) {
			$data['images'] = $this->hydrateImages($data['images']);
		}
		if (array_key_exists('summary', $data)) {
			$data['summary'] = $this->hydrateSummary($data['summary']);
		}
		return $this->hydrate(new Series(), $data);
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function createFilter(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (!empty($data['imdbId']) || !empty($data['zap2itId'])) {
			if (!empty($data['imdbId'])) {
				$data['externalIds']['imdbId'] = $data['imdbId'];
			}
			if (!empty($data['zap2itId'])) {
				$data['externalIds']['zap2itId'] = $data['zap2itId'];
			}
			$data['externalIds'] = $this->hydrate(new ExternalIds(), $data);
		}
		if (!empty($data['siteRating']) || !empty($data['siteRatingCount'])) {
			if (!empty($data['siteRating'])) {
				$data['rating'] = $data['siteRating'];
			}
			if (!empty($data['siteRatingCount'])) {
				$data['ratingCount'] = $data['siteRatingCount'];
			}
			$data['site'] = $this->hydrate(new Site(), $data);
		}
		if (!empty($data['network'])) {
			$data['network'] = $this->hydrate(new Network(), [
				'id'    =>  $data['networkId'],
				'name'  =>  $data['network']
			]);
		}
		return $this->hydrate(new Series\Filter(), $data);
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function createImageActor(array $data = [])
	{
		return $this->hydrate(new Series\ImageActor(), [
			'added'     =>  $data['imageAdded'],
			'author'    =>  $data['imageAuthor'],
			'path'      =>  $data['image']
		]);
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function createRating(array $data = [])
	{
		return $this->hydrate(new Rating(), [
			'itemId'    =>  $data['ratingItemId'],
			'note'      =>  $data['rating'],
			'type'      =>  $data['ratingType']
		]);
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
		foreach ($data as $item)
		{
			$collection->add(null, $this->create($item));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function createActorsCollection(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$collection = new GenericCollection();
		foreach ($data as $actor)
		{
			$actor['image'] = $this->createImageActor($actor);
			$collection->add(null, $this->hydrate(new Series\Actor(), $actor));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @param null $displayMode
	 * @return \TheTvDb\Model\Collection\FavoritesCollection
	 */
	public function createFavoritesCollection($data = [], $displayMode = null)
	{
		$collection = new FavoritesCollection();
		if (is_null($displayMode) && array_key_exists('displayMode', $data)) {
			$collection->setDisplayMode($data['displayMode']);
			unset($data['displayMode']);
		} elseif (!is_null($displayMode)) {
			$collection->setDisplayMode($displayMode);
		}
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (array_key_exists('favorites', $data)) {
			$favorites = $data['favorites'];
		} else {
			$favorites = $data;
		}
		foreach ($favorites as $favorite)
		{
			$collection->add(null, $this->create($favorite));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function createImagesQueryCollection($data = [])
	{
		$collection = new GenericCollection();
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		foreach ($data as $item)
		{
			$collection->add(null, $this->hydrateImageQuery($item));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function createImageParamsCollection($data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$collection = new GenericCollection();
		foreach ($data as $item)
		{
			$collection->add(null, $this->hydrateImageParams($item));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return int|\TheTvDb\Model\Common\GenericCollection
	 */
	public function createRatingsCollection($data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (empty($data)) {
			return 0;
		}
		$collection = new GenericCollection();
		foreach ($data as $rating)
		{
			$collection->add(null, $this->createRating($rating));
		}
		return $collection;
	}

	/**
	 * @param $data
	 * @return array
	 */
	public function createResolution($data)
	{
		$resolution = explode('x', $data);
		return [
			'height'    =>  $resolution[1],
			'width'     =>  $resolution[0]
		];
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function createResolutionsCollection($data = [])
	{
		$collection = new GenericCollection();
		foreach ($data as $resolution)
		{
			$collection->add(null, $this->hydrate(new Resolution(), $this->createResolution($resolution)));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrateImages($data = [])
	{
		if (array_key_exists('images', $data)) {
			$data = $data['images'];
		}
		$data['seasonWide'] = $data['images']['seasonwide'];
		$data['fanArt'] = $data['images']['fanart'];
		return $this->hydrate(new Series\Image(), $data);
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrateImageQuery($data = [])
	{
		$data['ratingsInfo'] = $this->hydrate(new Series\RatingsInfo(), $data['ratingsInfo']);
		$data['resolution'] = $this->hydrate(new Resolution(), $this->createResolution($data['resolution']));
		return $this->hydrate(new Query(), $data);
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrateImageParams($data = [])
	{
		$data['subKeys'] = $data['subKey'];
		$data['resolutions'] = $this->createResolutionsCollection($data['resolution']);
		return $this->hydrate(new Params(), $data);
	}

	/**
	 * @param $data
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrateSummary($data)
	{
		if (array_key_exists('summary', $data)) {
			$data = $data['summary'];
		}
		$data['airedSeasons'] = new CollectionToCommaSeparatedString($data['airedSeasons']);
		$data['dvdSeasons'] = new CollectionToCommaSeparatedString($data['dvdSeasons']);
		return $this->hydrate(new Series\Summary(), $data);
	}
}