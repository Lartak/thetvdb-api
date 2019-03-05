<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 03:42
 */

namespace TheTvDb\Factory;


use TheTvDb\Event\Events;
use TheTvDb\Event\HydratationEvent;
use TheTvDb\Http\HttpClient;
use TheTvDb\Model\AbstractModel;
use TheTvDb\Model\Common\CollectionToCommaSeparatedString;
use TheTvDb\Model\Common\GenericCollection;
use TheTvDb\Model\Common\ResultCollection;
use TheTvDb\Model\Series\Pagination;

/**
 * Class AbstractFactory
 *
 * @package TheTvDb\Factory
 */
abstract class AbstractFactory implements FactoryInterface
{
	/**
	 * @var HttpClient
	 */
	protected $httpClient;
	/**
	 * Constructor
	 *
	 * @param HttpClient $httpClient
	 */
	public function __construct(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}
	/**
	 * Get the http client
	 *
	 * @return HttpClient
	 */
	protected function getHttpClient()
	{
		return $this->httpClient;
	}
	/**
	 * Create a generic collection of data and map it on the class by it's static parameter $properties
	 *
	 * @param $class
	 * @param array $data
	 * @return GenericCollection
	 */
	protected function createGenericCollection($class, $data = [])
	{
		if (is_object($class)) {
			$class = get_class($class);
		}
		$collection = new GenericCollection();
		if (null === $data) {
			return $collection;
		}
		foreach ($data as $item) {
			$collection->add(null, $this->hydrate(new $class(), $item));
		}
		return $collection;
	}
	/**
	 * Create a result collection
	 *
	 * @param  array            $data
	 * @param  string           $method
	 * @return ResultCollection
	 */
	public function createResultCollection($data = [], $method = 'create')
	{
		$collection = new ResultCollection();
		if (is_null($data) || empty($data)) {
			return $collection;
		}
		if (array_key_exists('links', $data)) {
			$pagination = $data['links'];
			if (!is_int($pagination['first'])) {
				$pagination['first'] = (int)$pagination['first'];
			}
			if (!is_int($pagination['next'])) {
				$pagination['next'] = (int)$pagination['next'];
			}
			if (array_key_exists('prev', $pagination)) {
				if (!is_int($pagination['prev'])) {
					$pagination['prev'] = (int)$pagination['prev'];
				}
			}
			if (array_key_exists('last', $pagination)) {
				if (!is_int($pagination['last'])) {
					$pagination['last'] = (int)$pagination['last'];
				}
			}
			if (array_key_exists('current', $pagination)) {
				if (!is_int($pagination['current'])) {
					$pagination['current'] = (int)$pagination['current'];
				}
			}
			$collection->setPagination($this->hydrate(new Pagination(), $pagination));
		}
		if (array_key_exists('results', $data)) {
			$data = $data['results'];
		}
		foreach ($data as $item) {
			$collection->add(null, $this->$method($item));
		}
		return $collection;
	}
	/**
	 * Create a generic collection of data and map it on the class by it's static parameter $properties
	 *
	 * @param  AbstractModel     $class
	 * @param  GenericCollection $collection
	 * @param  array             $data
	 * @return GenericCollection
	 */
	protected function createCustomCollection($class, $collection, $data = [])
	{
		if (is_object($class)) {
			$class = get_class($class);
		}
		if (null === $data) {
			return $collection;
		}
		foreach ($data as $item) {
			$collection->add(null, $this->hydrate(new $class(), $item));
		}
		return $collection;
	}

	/**
	 * @param array $data
	 * @return \TheTvDb\Model\Common\CollectionToCommaSeparatedString
	 */
	public function createCollectionToCommaSeparatedString(array $data = [])
	{
		if (array_key_exists('data', $data)) {
			$data = $data['data'];
		}
		if (array_key_exists('params', $data)) {
			$data = $data['params'];
		}
		sort($data);
		return new CollectionToCommaSeparatedString($data);
	}
	/**
	 * Hydrate the object with data
	 *
	 * @param  AbstractModel $subject
	 * @param  array         $data
	 * @return AbstractModel
	 */
	protected function hydrate(AbstractModel $subject, $data = [])
	{
		$httpClient = $this->getHttpClient();
		$event = new HydratationEvent($subject, $data);
		$event->setLastRequest($httpClient->getLastRequest());
		$event->setLastResponse($httpClient->getLastResponse());
		$this->getHttpClient()->getEventDispatcher()->dispatch(Events::HYDRATE, $event);
		return $event->getSubject();
	}
}