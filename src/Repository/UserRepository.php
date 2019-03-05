<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 02:10
 */

namespace TheTvDb\Repository;


use TheTvDb\Factory\SeriesFactory;
use TheTvDb\Model\User;

/**
 * Class UserRepository
 *
 * @package TheTvDb\Repository
 */
class UserRepository extends AbstractRepository
{

	/**
	 * @param array $parameters
	 * @return \TheTvDb\Model\User
	 */
	public function infos(array $parameters = [])
	{
		$data = $this->getApi()->load();
		$user = new User();
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		$user
			->setLanguage($data['language'])
			->setUserName($data['userName']);
		if (array_key_exists('includes', $parameters)) {
			foreach ($parameters['includes'] as $include)
			{
				switch ($include)
				{
					case 'favorites':
						$user->setFavorites($this->favorites($data['favoritesDisplaymode']));
						break;
					case 'ratings':
						$data = $this->getApi()->ratings();
						$user->setRatings($this->getFactory()->createRatingsCollection($data['data']));
						break;
				}
			}
		}
		return $user;
	}

	/**
	 * @param string|null $favoritesDisplayMode
	 * @return \TheTvDb\Model\Collection\FavoritesCollection
	 */
	public function favorites($favoritesDisplayMode = null)
	{
		if (is_null($favoritesDisplayMode)) {
			$userData = $this->getApi()->load();
			$favoritesDisplayMode = $userData['data']['favoritesDisplaymode'];
		}
		$data = $this->getApi()->favorites();
		return $this->getFactory()->createFavoritesCollection($data, $favoritesDisplayMode);
	}

	/**
	 * @return mixed
	 */
	public function favoritesList()
	{
		$favorites = $this->getApi()->favoritesList();
		return $this->getFactory()->createCollectionToCommaSeparatedString($favorites['data']['favorites']);
	}

	/**
	 * @param int $id
	 * @return \TheTvDb\Model\Collection\FavoritesCollection
	 */
	public function addFavorite($id)
	{
		$data = $this->getApi()->addFavorite($id);
		return $this->getFactory()->createFavoritesCollection($this->getApi()->favorites($data));
	}

	/**
	 * @param int $id
	 * @return \TheTvDb\Model\Collection\FavoritesCollection
	 */
	public function removeFavorite($id)
	{
		$data = $this->getApi()->removeFavorite($id);
		return $this->getFactory()->createFavoritesCollection($this->getApi()->favorites($data));
	}

	/**
	 * @return int|\TheTvDb\Model\Common\GenericCollection
	 */
	public function ratings()
	{
		$data = $this->getApi()->ratings();
		return $this->getFactory()->createRatingsCollection($data['data']);
	}

	/**
	 * @param $itemType
	 * @return int|\TheTvDb\Model\Common\GenericCollection
	 */
	public function ratingsQuery($itemType)
	{
		$data = $this->getApi()->ratingsQuery($itemType);
		return $this->getFactory()->createRatingsCollection($data['data']);
	}

	/**
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function ratingsQueryParams()
	{
		$data = $this->getApi()->ratingsQueryParams();
		return $this->getFactory()->createCollectionToCommaSeparatedString($data['data']);
	}

	/**
	 * @param int $itemId
	 * @param string $itemType
	 * @param string $itemRating
	 * @return int|mixed|\TheTvDb\Model\Common\GenericCollection
	 */
	public function updateRating($itemId, $itemType, $itemRating)
	{
		$data = $this->getApi()->updateRating($itemId, $itemType, $itemRating);
		if (!empty($data['data'])) {
			return $this->getFactory()->createRatingsCollection($data);
		}
		return $data;
	}

	/**
	 * @param int $itemId
	 * @param string $itemType
	 * @return int|mixed|\TheTvDb\Model\Common\GenericCollection
	 */
	public function removeRating($itemId, $itemType)
	{
		$data = $this->getApi()->removeRating($itemId, $itemType);
		if (!empty($data['data'])) {
			return $this->getFactory()->createRatingsCollection($data);
		}
		return $data;
	}
	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\User
	 */
	public function getApi()
	{
		return $this->client->getUserApi();
	}

	/**
	 * Return the Factory Class
	 *
	 * @return SeriesFactory
	 */
	public function getFactory()
	{
		return new SeriesFactory($this->client->getHttpClient());
	}
}