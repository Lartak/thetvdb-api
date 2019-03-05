<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:24
 */

namespace TheTvDb\Http;


use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Monolog\Logger;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TheTvDb\Common\ParameterBag;
use TheTvDb\Event\Events;
use TheTvDb\Event\HydratationSubscriber;
use TheTvDb\Event\RequestEvent;
use TheTvDb\Event\RequestSubscriber;
use TheTvDb\Http\Adapter\AdapterInterface;
use TheTvDb\Http\Adapter\GuzzleAdapter;
use TheTvDb\Http\Plugin\LanguageHeaderPlugin;
use TheTvDb\Http\Plugin\TokenHeaderPlugin;
use TheTvDb\Token;

/**
 * Class HttpClient
 *
 * @package TheTvDb\Http
 */
class HttpClient
{
	/**
	 * @var AdapterInterface
	 */
	private $adapter;
	/**
	 * @var EventDispatcher
	 */
	private $eventDispatcher;
	/**
	 * @var array
	 */
	protected $options;
	/**
	 * The base url to built requests on top of
	 *
	 * @var null
	 */
	protected $base_url = null;
	/**
	 * @var Response
	 */
	private $lastResponse;
	/**
	 * @var Request
	 */
	private $lastRequest;
	/**
	 * @var Token
	 */
	private $token;
	/**
	 * @var string|null
	 */
	private $language;
	/**
	 * Constructor
	 *
	 * @param array $options
	 */
	public function __construct(array $options = [])
	{
		$this->options         = $options;
		$this->base_url        = $this->options['host'];
		$this->eventDispatcher = $this->options['event_dispatcher'];
		$this->setAdapter($this->options['adapter']);
		$this->processOptions();
	}
	/**
	 * {@inheritDoc}
	 */
	public function get($path, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'GET', $parameters, $headers);
	}
	/**
	 * {@inheritDoc}
	 */
	public function post($path, $body, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'POST', $parameters, $headers, $body);
	}
	/**
	 * {@inheritDoc}
	 */
	public function head($path, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'HEAD', $parameters, $headers);
	}
	/**
	 * {@inheritDoc}
	 */
	public function put($path, $body = null, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'PUT', $parameters, $headers, $body);
	}
	/**
	 * {@inheritDoc}
	 */
	public function patch($path, $body = null, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'PATCH', $parameters, $headers, $body);
	}
	/**
	 * {@inheritDoc}
	 */
	public function delete($path, $body = null, array $parameters = [], array $headers = [])
	{
		return $this->send($path, 'DELETE', $parameters, $headers, $body);
	}
	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
	/**
	 * @param  array $options
	 * @return $this
	 */
	public function setOptions($options)
	{
		$this->options = $options;
		return $this;
	}
	/**
	 * @return EventDispatcher
	 */
	public function getEventDispatcher()
	{
		return $this->eventDispatcher;
	}

	/**
	 * @return \TheTvDb\Http\Request
	 */
	public function getLastRequest()
	{
		return $this->lastRequest;
	}

	/**
	 * @return \TheTvDb\Http\Response
	 */
	public function getLastResponse()
	{
		return $this->lastResponse;
	}
	/**
	 * Get the current base url
	 *
	 * @return null|string
	 */
	public function getBaseUrl()
	{
		return $this->base_url;
	}
	/**
	 * Set the base url secure / insecure
	 *
	 * @param $url
	 * @return HttpClient
	 */
	public function setBaseUrl($url)
	{
		$this->base_url = $url;
		return $this;
	}
	/**
	 * Create the request object and send it out to listening events.
	 *
	 * @param $path
	 * @param $method
	 * @param  array  $parameters
	 * @param  array  $headers
	 * @param  null   $body
	 * @return string
	 */
	private function send($path, $method, array $parameters = [], array $headers = [], $body = null)
	{
		$request = $this->createRequest(
			$path,
			$method,
			$parameters,
			$headers,
			$body
		);
		$event = new RequestEvent($request);
		$this->eventDispatcher->dispatch(Events::REQUEST, $event);
		$this->lastResponse = $event->getResponse();
		if ($this->lastResponse instanceof Response) {
			return (string) $this->lastResponse->getBody();
		}
		return '';
	}
	/**
	 * Create the request object
	 *
	 * @param $path
	 * @param $method
	 * @param  array   $parameters
	 * @param  array   $headers
	 * @param $body
	 * @return Request
	 */
	private function createRequest($path, $method, $parameters = [], $headers = [], $body = null)
	{
		$request =  new Request();
		$request
			->setPath($path)
			->setMethod($method)
			->setParameters(new ParameterBag((array)$parameters))
			->setHeaders(new ParameterBag((array)$headers))
			->setBody($body)
			->setOptions(new ParameterBag((array)$this->options))
		;
		return $this->lastRequest = $request;
	}
	/**
	 * Add a subscriber
	 *
	 * @param EventSubscriberInterface $subscriber
	 */
	public function addSubscriber(EventSubscriberInterface $subscriber)
	{
		if ($subscriber instanceof HttpClientEventSubscriber) {
			$subscriber->attachHttpClient($this);
		}
		$this->eventDispatcher->addSubscriber($subscriber);
	}
	/**
	 * Remove a subscriber
	 *
	 * @param EventSubscriberInterface $subscriber
	 */
	public function removeSubscriber(EventSubscriberInterface $subscriber)
	{
		if ($subscriber instanceof HttpClientEventSubscriber) {
			$subscriber->attachHttpClient($this);
		}
		$this->eventDispatcher->removeSubscriber($subscriber);
	}
	/**
	 * @return Token
	 */
	public function getToken()
	{
		return $this->token;
	}
	/**
	 * Add an subscriber to append the session_token to the query parameters.
	 *
	 * @param Token $token
	 */
	public function setToken(Token $token)
	{
		$this->addSubscriber(new TokenHeaderPlugin($token));
		$this->token = $token;
	}

	/**
	 * @return string|null
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 * @param $language
	 */
	public function setLanguage($language)
	{
		$this->addSubscriber(new LanguageHeaderPlugin($language));
		$this->language = $language;
	}
	/**
	 * @return AdapterInterface
	 */
	public function getAdapter()
	{
		return $this->adapter;
	}
	/**
	 * @param  AdapterInterface $adapter
	 * @return $this
	 */
	public function setAdapter(AdapterInterface $adapter)
	{
		$adapter->registerSubscribers($this->getEventDispatcher());
		$this->adapter = $adapter;
		return $this;
	}
	/**
	 * Register the default plugins
	 *
	 * @return $this
	 */
	public function registerDefaults()
	{
		if (array_key_exists('token', $this->options) && !is_null($this->options['token'])) {
			$this->addSubscriber(new TokenHeaderPlugin(
				is_string($this->options['token']) ?
					new Token($this->options['token']):
					$this->options['token']
			));
		}
		if (array_key_exists('language', $this->options)) {
			$this->addSubscriber(new LanguageHeaderPlugin($this->options['language']));
		}
		$this->addSubscriber(new RequestSubscriber());
		$this->addSubscriber(new HydratationSubscriber());
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isDefaultAdapter()
	{
		if (!class_exists('GuzzleHttp\Client')) {
			return false;
		}
		return ($this->getAdapter() instanceof GuzzleAdapter);
	}

	protected function processOptions()
	{
		$token = $this->token;
		if (!is_null($token) && $token->getToken() == $this->options['token']) {
			$this->setToken($token);
		}
		$cache = $this->options['cache'];
		if ($cache['enabled']) {
			$this->setupCache($cache);
		}
		$log = $this->options['log'];
		if ($log['enabled']) {
			$this->setupLog($log);
		}
	}

	/**
	 * @param array $cache
	 */
	protected function setupCache(array $cache)
	{
		if ($this->isDefaultAdapter()) {
			$this->setDefaultCaching($cache);
		} elseif (null !== $subscriber = $cache['subscriber']) {
			$subscriber->setOptions($cache);
			$this->addSubscriber($subscriber);
		}
	}

	/**
	 * @param array $log
	 */
	protected function setupLog(array $log)
	{
		if ($this->isDefaultAdapter()) {
			$this->setDefaultLogging($log);
		} elseif (null !== $subscriber = $log['subscriber']) {
			$subscriber->setOptions($log);
			$this->addSubscriber($subscriber);
		}
	}
	/**
	 * Add an subscriber to enable caching.
	 *
	 * @param  array             $parameters
	 * @throws \RuntimeException
	 * @return $this
	 */
	public function setDefaultCaching(array $parameters)
	{
		if ($parameters['enabled']) {
			if (!class_exists('Doctrine\Common\Cache\CacheProvider')) {
				//@codeCoverageIgnoreStart
				throw new \RuntimeException(
					'Could not find the doctrine cache library,
                    have you added doctrine-cache to your composer.json?'
				);
				//@codeCoverageIgnoreEnd
			}
			$this->adapter->getClient()->getConfig('handler')->push(
				new CacheMiddleware(
					new PrivateCacheStrategy(
						new DoctrineCacheStorage(
							$parameters['handler']
						)
					)
				),
				'thetvdb-cache'
			);
		}
		return $this;
	}
	/**
	 * Enable logging
	 *
	 * @param  array             $parameters
	 * @throws \RuntimeException
	 * @return $this
	 */
	public function setDefaultLogging(array $parameters)
	{
		if ($parameters['enabled']) {
			if (!class_exists('\Monolog\Logger')) {
				//@codeCoverageIgnoreStart
				throw new \RuntimeException(
					'Could not find any logger set and the monolog logger library was not found
                    to provide a default, you have to  set a custom logger on the client or
                    have you forgot adding monolog to your composer.json?'
				);
				//@codeCoverageIgnoreEnd
			}
			$logger = new Logger('php-thetvdb-api');
			$logger->pushHandler($parameters['handler']);
			if ($this->getAdapter() instanceof GuzzleAdapter) {
				$middleware = new \Concat\Http\Middleware\Logger($logger);
				$middleware->setRequestLoggingEnabled(true);
				$middleware->setLogLevel(function() {
					return LogLevel::DEBUG;
				});
				$this->getAdapter()->getClient()->getConfig('handler')->push(
					$middleware,
					'thetvdb-log'
				);
			}
		}
		return $this;
	}
}