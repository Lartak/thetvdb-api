<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:32
 */

namespace TheTvDb\Model;


/**
 * Class User
 *
 * @package TheTvDb\Model
 */
class User extends AbstractModel
{
	/**
	 * @var \TheTvDb\Model\Collection\FavoritesCollection|null
	 */
	private $favorites;
	/**
	 * @var string
	 */
	private $language;
	/**
	 * @var \TheTvDb\Model\Common\GenericCollection|null|int
	 */
	private $ratings;
	/**
	 * @var string
	 */
	private $userName;
	/**
	 * @var array
	 */
	public static $properties = [
		'favorites', 'language', 'ratings', 'username'
	];

	/**
	 * @return \TheTvDb\Model\Collection\FavoritesCollection|null
	 */
	public function getFavorites()
	{
		return $this->favorites;
	}

	/**
	 * @param \TheTvDb\Model\Collection\FavoritesCollection|null $favorites
	 * @return User
	 */
	public function setFavorites($favorites)
	{
		$this->favorites = $favorites;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param string $language
	 * @return User
	 */
	public function setLanguage($language)
	{
		$this->language = $language;

		return $this;
	}

	/**
	 * @return \TheTvDb\Model\Common\GenericCollection|null|int
	 */
	public function getRatings()
	{
		return $this->ratings;
	}

	/**
	 * @param \TheTvDb\Model\Common\GenericCollection|null|int $ratings
	 * @return User
	 */
	public function setRatings($ratings)
	{
		$this->ratings = $ratings;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUserName()
	{
		return $this->userName;
	}

	/**
	 * @param string $userName
	 * @return User
	 */
	public function setUserName($userName)
	{
		$this->userName = $userName;

		return $this;
	}
}