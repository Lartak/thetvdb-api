<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:00
 */

namespace TheTvDb\Http\Adapter;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheTvDb\Common\ParameterBag;
use TheTvDb\Exception\NullResponseException;
use TheTvDb\Http\Request;
use TheTvDb\Http\Response;

/**
 * Class GuzzleAdapter
 *
 * @package TheTvDb\Http\Adapter
 */
class GuzzleAdapter extends AbstractAdapter
{
	/**
	 * @var ClientInterface
	 */
	private $client;
	/**
	 * @var Request
	 */
	protected $request;

	/**
	 * GuzzleAdapter constructor.
	 *
	 * @param \GuzzleHttp\ClientInterface|null $client
	 * @param array $options
	 */
	public function __construct(ClientInterface $client = null, array $options = [])
	{
		if (null === $client) {
			$client = new Client($options);
		}
		$this->client = $client;
	}

	/**
	 * @param \Symfony\Component\EventDispatcher\EventDispatcherInterface $eventDispatcher
	 */
	public function registerSubscribers(EventDispatcherInterface $eventDispatcher)
	{
		/** @var HandlerStack $handler */
		$handler = $this->client->getConfig('handler');
		$handler->push(Middleware::retry(function(
			$retries,
			\GuzzleHttp\Psr7\Request $request,
			\GuzzleHttp\Psr7\Response $response = null,
			RequestException $exception = null
		){
			if ($retries >= 5) {
				return false;
			}
			// Retry connection exception
			if ($exception instanceof ConnectException) {
				return true;
			}
			if ($response) {
				if($response->getStatusCode() >= 500) {
					return true;
				}
				if($response->getStatusCode() === 429) {
					$sleep = (int) $response->getHeaderLine('retry-after');
					/**
					 * @see https://github.com/php-tmdb/api/issues/154
					 * Maybe it's even better to set it to $retries value
					 */
					if (0 === $sleep) $sleep = 1;
					if ($sleep > 10) {
						return false;
					}
					sleep($sleep);
					return true;
				}
			}
			return false;
		}));
	}
	/**
	 * Format the request for Guzzle
	 *
	 * @param  Request $request
	 * @return array
	 */
	public function getConfiguration(Request $request)
	{
		$this->request = $request;
		return [
			'base_uri' => $request->getOptions()->get('base_url'),
			'headers'  => $request->getHeaders()->all(),
			'query'    => $request->getParameters()->all()
		];
	}
	/**
	 * Create the response object
	 *
	 * @param  ResponseInterface $adapterResponse
	 * @return \TheTvDb\Http\Response
	 */
	private function createResponse(ResponseInterface $adapterResponse = null)
	{
		$response = new Response();
		if ($adapterResponse !== null) {
			$response->setCode($adapterResponse->getStatusCode());
			$response->setHeaders(new ParameterBag($adapterResponse->getHeaders()));
			$response->setBody((string) $adapterResponse->getBody());
		}
		return $response;
	}
	/**
	 * Create the request exception
	 *
	 * @param  Request                          $request
	 * @param  RequestException|null            $previousException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	protected function handleRequestException(Request $request, RequestException $previousException)
	{
		if (null !== $previousException) {
			$response = $previousException->getResponse();
			if (null == $response || ($response->getStatusCode() >= 500 && $response->getStatusCode() <= 599)) {
				throw new NullResponseException($this->request, $previousException);
			}
		}
		throw $this->createApiException(
			$request,
			$this->createResponse($previousException->getResponse()),
			$previousException
		);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function get(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'GET',
				$request->getPath(),
				$this->getConfiguration($request)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function post(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'POST',
				$request->getPath(),
				array_merge(
					['body' => $request->getBody()],
					$this->getConfiguration($request)
				)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function put(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'PUT',
				$request->getPath(),
				array_merge(
					['body' => $request->getBody()],
					$this->getConfiguration($request)
				)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function patch(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'PATCH',
				$request->getPath(),
				array_merge(
					['body' => $request->getBody()],
					$this->getConfiguration($request)
				)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function delete(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'DELETE',
				$request->getPath(),
				array_merge(
					['body' => $request->getBody()],
					$this->getConfiguration($request)
				)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}

	/**
	 * @param \TheTvDb\Http\Request $request
	 * @return \TheTvDb\Http\Response
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TheTvDb\Exception\ApiException
	 */
	public function head(Request $request)
	{
		$response = null;
		try {
			$response = $this->client->request(
				'HEAD',
				$request->getPath(),
				$this->getConfiguration($request)
			);
		} catch (RequestException $e) {
			$this->handleRequestException($request, $e);
		}
		return $this->createResponse($response);
	}
	/**
	 * Retrieve the Guzzle Client
	 *
	 * @return Client
	 */
	public function getClient()
	{
		return $this->client;
	}
	/**
	 * @param  ClientInterface $client
	 * @return $this
	 */
	public function setClient(ClientInterface $client)
	{
		$this->client = $client;
		return $this;
	}
}