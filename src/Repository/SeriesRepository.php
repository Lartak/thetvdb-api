<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 00:56
 */

namespace TheTvDb\Repository;


use TheTvDb\Factory\EpisodeFactory;
use TheTvDb\Factory\SeriesFactory;

/**
 * Class SeriesRepository
 *
 * @package TheTvDb\Repository
 */
class SeriesRepository extends AbstractRepository
{

	/**
	 * @param $id
	 * @param array $parameters
	 * @param array $headers
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function load($id, array $parameters = [], array $headers = [])
	{
		$data = $this->getApi()->load($id, $headers);
		if (array_key_exists('includes', $parameters)) {
			foreach ($parameters['includes'] as $include)
			{
				switch ($include)
				{
					case 'actors':
						$data['data']['actors'] = $this->getActors($id, $headers);
						break;
					case 'episodes':
						if (!empty($include['headers'])) {
							$headers = array_merge($headers, $include['headers']);
						}
						unset($parameters['includes']);
						$page = array_key_exists('page', $parameters) ? (int)$parameters['page'] : 1;
						$episodesData = $this->getApi()->getEpisodes($id, $page, $headers);
						$episodes = [];
						foreach ($episodesData['data'] as $episode)
						{
							$episodes['data'][$episode['airedEpisodeNumber']] = $episode;
						}
						$episodes['current'] = $page;
						$episodes['results'] = $episodes['data'];
						$data['data']['episodes'] = $this->getEpisodeFactory()->createResultCollection($episodes);
						break;
					case 'images':
						if (array_key_exists('headers', $include)) {
							$headers = array_merge($headers, $include['headers']);
						}
						$data['data']['images'] = $this->getImages($id, $headers);
						break;
					case 'summary':
						$data['data']['summary'] = $this->getSummary($id);
						break;
				}
			}
		}
		return $this->getFactory()->create($data);
	}

	/**
	 * @param $id
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\GenericCollection
	 */
	public function getActors($id, array $headers = [])
	{
		$actors = $this->getApi()->getActors($id, $headers);
		return $this->getFactory()->createActorsCollection($actors['data']);
	}

	/**
	 * @param string|int $id
	 * @param int|string $page
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\ResultCollection
	 */
	public function getEpisodes($id, $page = 1, $headers = [])
	{
		$data = $this->getApi()->getEpisodes($id, $page, $headers);
		$data['results'] = $data['data'];
		unset($data['data']);
		$data['links']['current'] = $page;
		return $this->getEpisodeFactory()->createResultCollection($data);
	}

	/**
	 * @param string|int $id
	 * @param int|string|null $page
	 * @param array $parameters
	 * @return \TheTvDb\Model\AbstractModel|\TheTvDb\Model\Collection\EpisodesCollection|\TheTvDb\Model\Common\ResultCollection|null
	 */
	public function getEpisodesQuery($id, $page = 1, array $parameters = [])
	{
		$data = $this->getApi()->getEpisodesQuery($id, $parameters);
		if (array_key_exists('airedSeason', $parameters)) {
			$episodes = [];
			foreach ($data['data'] as $episode)
			{
				$episodes[$episode['airedEpisodeNumber']] = $episode;
			}
			ksort($episodes);
			$data['data'] = $episodes;
		}
		if (!is_null($page)) {
			$data['results'] = $data['data'];
			unset($data['data']);
			$data['links']['current'] = $page;
			return $this->getEpisodeFactory()->createResultCollection($data);
		}
		if (count($data['data']) > 1) {
			return $this->getEpisodeFactory()->createEpisodesCollection($data);
		} elseif (count($data['data']) === 1) {
			return $this->getEpisodeFactory()->create($data['data'][0]);
		}
		return null;
	}

	/**
	 * @param $id
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function episodesQueryParams($id, $headers = [])
	{
		$data = $this->getApi()->getEpisodesQueryParams($id, $headers);
		return $this->getFactory()->createCollectionToCommaSeparatedString($data['data']);
	}

	/**
	 * @param $id
	 * @param array $headers
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function getImages($id, $headers = [])
	{
		$images = $this->getApi()->images($id, $headers);
		return $this->getFactory()->hydrateImages($images['data']);
	}

	/**
	 * @param $id
	 * @param $parameters
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\GenericCollection
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function getImagesQuery($id, $parameters, $headers = [])
	{
		$images = $this->getApi()->getImagesQuery($id, $parameters, $headers);
		return $this->getFactory()->createImagesQueryCollection($images);
	}

	/**
	 * @param $id
	 * @param array $headers
	 * @return mixed
	 */
	public function getImagesQueryParams($id, $headers = [])
	{
		$data = $this->getApi()->getImagesQueryParams($id, $headers);
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		return $this->getFactory()->createImageParamsCollection($data);
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function getSummary($id)
	{
		$data = $this->getApi()->getSummary($id);
		sort($data['data']['airedSeasons']);
		sort($data['data']['dvdSeasons']);
		return $data['data'];
	}

	/**
	 * @param int $id
	 * @param string|array $keys
	 * @param array $headers
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function filter($id, $keys, $headers = [])
	{
		$data = $this->getApi()->filter($id, $keys, $headers);
		return $this->getFactory()->createFilter($data['data']);
	}

	/**
	 * @param $id
	 * @param array $headers
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function filterParams($id, $headers = [])
	{
		$data = $this->getApi()->filterParams($id, $headers);
		return $this->getFactory()->createCollectionToCommaSeparatedString($data['data']['params']);
	}

	/**
	 * @param $id
	 * @param $season
	 * @param int|string $page
	 * @return \TheTvDb\Model\Common\ResultCollection
	 */
	public function findEpisodesBySeason($id, $season, $page = 1)
	{
		$parameters['airedSeason'] = (is_int($season) && $season === 0) ? '0' : $season;
		$data =  $this->getEpisodesQuery($id, $page, $parameters);
		return $data;
	}

	/**
	 * @param $id
	 * @param $episodeNumber
	 * @param int $page
	 * @return \TheTvDb\Model\Common\ResultCollection
	 */
	public function findEpisodesByNumber($id, $episodeNumber, $page = 1)
	{
		$parameters['airedEpisode'] = $episodeNumber;
		return $this->getEpisodesQuery($id, $page, $parameters);
	}

	/**
	 * @param $id
	 * @param $absoluteNumber
	 * @return \TheTvDb\Model\Collection\EpisodesCollection|\TheTvDb\Model\Episode\null
	 */
	public function findEpisodeByAbsoluteNumber($id, $absoluteNumber)
	{
		$parameters['absoluteNumber'] = $absoluteNumber;
		return $this->getEpisodesQuery($id, null, $parameters);
	}

	/**
	 * Return the API Class
	 *
	 * @return \TheTvDb\Api\Series
	 */
	public function getApi()
	{
		return $this->client->getSeriesApi();
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

	/**
	 * @return \TheTvDb\Factory\EpisodeFactory
	 */
	public function getEpisodeFactory()
	{
		return new EpisodeFactory($this->client->getHttpClient());
	}
}