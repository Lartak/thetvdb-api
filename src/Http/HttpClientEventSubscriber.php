<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:29
 */

namespace TheTvDb\Http;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HttpClientEventSubscriber
 *
 * @package TheTvDb\Http
 */
abstract class HttpClientEventSubscriber implements EventSubscriberInterface
{
	/**
	 * @var HttpClient
	 */
	private $httpClient;
	/**
	 * @param HttpClient $httpClient
	 */
	public function attachHttpClient(HttpClient $httpClient)
	{
		$this->httpClient = $httpClient;
	}
	/**
	 * @return HttpClient
	 */
	public function getHttpClient()
	{
		return $this->httpClient;
	}
}