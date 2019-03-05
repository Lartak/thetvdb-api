<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 08:30
 */

namespace TheTvDb\Api;


use TheTvDb\Exception\ApiException;
use TheTvDb\Exception\InvalidArgumentException;

/**
 * Class User
 *
 * @package TheTvDb\Api
 */
class User extends AbstractApi
{
	const BASE_URI = '/user';
	const ITEM_TYPES_FOR_QUERY = [
		'series', 'episode', 'banner'
	];
	const RATINGS_ITEM_TYPES = [
		'series', 'episode', 'images'
	];

	/**
	 * @return mixed
	 */
	public function load()
	{
		return $this->get(self::BASE_URI);
	}

	/**
	 * @param array $list
	 * @return mixed
	 */
	public function favorites(array $list = [])
	{
		if (empty($list)) {
			$list = $this->favoritesList();
		}
		if (array_key_exists('data', $list)) {
			$list = $list['data'];
		}
		if (array_key_exists('favorites', $list)) {
			$list = $list['favorites'];
		}
		$data = [];
		foreach ($list as $favorite)
		{
			$show = $this->client->getSeriesApi()->load((int)$favorite);
			array_push($data, $show['data']);
		}
		return $data;
	}

	/**
	 * @return mixed
	 */
	public function favoritesList()
	{
		return $this->get(self::BASE_URI . '/favorites');
	}

	/**
	 * Add an favorite in User Account
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function addFavorite($id)
	{
		return $this->put(sprintf('%s/%s/%d', self::BASE_URI, 'favorites', $id));
	}

	/**
	 * Remove an favorite from User Account
	 *
	 * @param int $id
	 * @return mixed
	 */
	public function removeFavorite($id)
	{
		return $this->delete(sprintf('%s/%s/%d', self::BASE_URI, 'favorites', $id));
	}

	/**
	 * @return mixed
	 */
	public function ratings()
	{
		return $this->get(self::BASE_URI . '/ratings');
	}

	/**
	 * @param $itemType
	 * @return mixed
	 * @throws \TheTvDb\Exception\InvalidArgumentException
	 */
	public function ratingsQuery($itemType)
	{
		if (!in_array($itemType, self::ITEM_TYPES_FOR_QUERY)) {
			throw new InvalidArgumentException(sprintf('No record found with argument [%s]', $itemType), ApiException::STATUS_NOT_FOUND);
		}
		return $this->get(self::BASE_URI . '/ratings/query', compact('itemType'));
	}

	/**
	 * @return mixed
	 */
	public function ratingsQueryParams()
	{
		return $this->get(self::BASE_URI . '/ratings/query/params');
	}

	/**
	 * @param int $itemId
	 * @param string $itemType
	 * @param string $itemRating
	 * @return mixed
	 */
	public function updateRating($itemId, $itemType, $itemRating)
	{
		if (!in_array($itemType, self::RATINGS_ITEM_TYPES)) {
			throw new InvalidArgumentException(sprintf('No record found with argument [%s]', $itemType), ApiException::STATUS_NOT_FOUND);
		}
		return $this->put(self::BASE_URI . '/ratings/' . sprintf('%s/%d/%s', $itemType, $itemId, $itemRating));
	}

	/**
	 * @param int $itemId
	 * @param string $itemType
	 * @return mixed
	 * @throws \TheTvDb\Exception\InvalidArgumentException
	 */
	public function removeRating($itemId, $itemType)
	{
		if (!in_array($itemType, self::RATINGS_ITEM_TYPES)) {
			throw new InvalidArgumentException(sprintf('No record found with argument [%s]', $itemType), ApiException::STATUS_NOT_FOUND);
		}
		return $this->put(self::BASE_URI . '/ratings/' . sprintf('%s/%d', $itemType, $itemId));
	}
}