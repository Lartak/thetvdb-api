<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:56
 */

namespace TheTvDb;


use Doctrine\Common\Cache\FilesystemCache;
use GuzzleHttp\Handler\StreamHandler;
use Psr\Log\LogLevel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TheTvDb\Api\MethodsTrait;
use TheTvDb\Http\Adapter\AdapterInterface;
use TheTvDb\Http\Adapter\GuzzleAdapter;
use TheTvDb\Http\HttpClient;

/**
 * Class Client
 *
 * @package TheTvDb
 */
class Client
{
	use MethodsTrait;
	/** Client Version */
	const VERSION  = '2.1.10';
	/** Base API URI */
	const API_URI = 'api.thetvdb.com';
	/** Insecure schema */
	const SCHEME_INSECURE = 'http';
	/** Secure schema */
	const SCHEME_SECURE = 'https';
	/**
	 * Stores the HTTP Client
	 *
	 * @var HttpClient
	 */
	private $httpClient;
	/**
	 * Store the options
	 *
	 * @var array
	 */
	private $options = [];
	/**
	 * Construct our client
	 *
	 * @param Token|null $token
	 * @param array    $options
	 */
	public function __construct(Token $token = null, $options = [])
	{
		if ($options instanceof ConfigurationInterface) {
			$options = $options->all();
		}
		if (!is_null($token)) {
			$this->configureOptions(array_replace(['token' => $token], (array)$options));
		} else {
			$this->configureOptions($options);
		}
		$this->constructHttpClient();
	}
	/**
	 * @param  Token $token
	 * @return $this
	 */
	public function setToken($token)
	{
		$this->options['token'] = $token;
		$this->reconstructHttpClient();
		return $this;
	}
	/**
	 * @return Token|null
	 */
	public function getToken()
	{
		return $this->options['token'];
	}
	/**
	 * @param string $language
	 * @return $this
	 */
	public function setLanguage($language)
	{
		$this->options['language'] = $language;
		$this->reconstructHttpClient();
		return $this;
	}
	/**
	 * @return string|null
	 */
	public function getLanguage()
	{
		return $this->options['language'];
	}
	/**
	 * @param HttpClient $httpClient
	 */
	public function setHttpClient(HttpClient $httpClient)
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
	/**
	 * Get the adapter
	 *
	 * @return AdapterInterface
	 */
	public function getAdapter()
	{
		return $this->options['adapter'];
	}
	/**
	 * Get the event dispatcher
	 *
	 * @return AdapterInterface
	 */
	public function getEventDispatcher()
	{
		return $this->options['event_dispatcher'];
	}
	/**
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
	/**
	 * @param string $key
	 *
	 * @return array
	 */
	public function getOption($key)
	{
		return array_key_exists($key, $this->options) ? $this->options[$key] : null;
	}

	/**
	 * @param array $options
	 * @return \TheTvDb\Client
	 */
	public function setOptions(array $options = [])
	{
		$this->options = $this->configureOptions($options);
		return $this;
	}
	/**
	 * Construct the http client
	 *
	 * In case you are implementing your own adapter, the base url will be passed on through the options bag
	 * at every call in the respective get / post methods etc. of the adapter.
	 *
	 * @return void
	 */
	protected function constructHttpClient()
	{
		$hasHttpClient = (null !== $this->httpClient);
		$this->httpClient = new HttpClient($this->getOptions());
		if (!$hasHttpClient) {
			$this->httpClient->registerDefaults();
		}
	}
	/**
	 * Reconstruct the HTTP Client
	 */
	protected function reconstructHttpClient()
	{
		if (null !== $this->getHttpClient()) {
			$this->constructHttpClient();
		}
	}
	/**
	 * Configure options
	 *
	 * @param  array $options
	 * @return array
	 */
	protected function configureOptions(array $options)
	{
		$resolver = new OptionsResolver();
		$resolver->setDefaults([
			'adapter'           =>  null,
			'secure'            =>  true,
			'host'              =>  self::API_URI,
			'base_url'          =>  null,
			'token'             =>  null,
			'language'          =>  null,
			'event_dispatcher'  =>  array_key_exists('event_dispatcher', $this->options) ? $this->options['event_dispatcher'] : new EventDispatcher(),
			'cache'             =>  [],
			'log'               =>  [],
		]);
		$resolver->setRequired([
			'adapter',
			'host',
			'token',
			'language',
			'secure',
			'event_dispatcher',
			'cache',
			'log'
		]);
		$resolver->setAllowedTypes('adapter', ['object', 'null']);
		$resolver->setAllowedTypes('host', ['string']);
		$resolver->setAllowedTypes('secure', ['bool']);
		$resolver->setAllowedTypes('token', ['object', 'null']);
		$resolver->setAllowedTypes('language', ['string', 'null']);
		$resolver->setAllowedTypes('event_dispatcher', ['object']);
		$this->options = $resolver->resolve($options);
		$this->postResolve($options);
		return $this->options;
	}
	/**
	 * Configure caching
	 *
	 * @param  array $options
	 * @return array
	 */
	protected function configureCacheOptions(array $options = [])
	{
		$resolver = new OptionsResolver();
		$resolver->setDefaults([
			'enabled'    => true,
			'handler'    => null,
			'subscriber' => null,
			'path'       => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'php-thetvdb-api',
		]);
		$resolver->setRequired(['enabled', 'handler']);
		$resolver->setAllowedTypes('enabled', ['bool']);
		$resolver->setAllowedTypes('handler', ['object', 'null']);
		$resolver->setAllowedTypes('subscriber', ['object', 'null']);
		$resolver->setAllowedTypes('path', ['string', 'null']);
		$options = $resolver->resolve(array_key_exists('cache', $options) ? $options['cache'] : []);
		if ($options['enabled'] && !$options['handler']) {
			$options['handler'] = new FilesystemCache($options['path']);
		}
		return $options;
	}
	/**
	 * Configure logging
	 *
	 * @param  array $options
	 * @return array
	 */
	protected function configureLogOptions(array $options = [])
	{
		$resolver = new OptionsResolver();
		$resolver->setDefaults([
			'enabled'    => false,
			'level'      => LogLevel::DEBUG,
			'handler'    => null,
			'subscriber' => null,
			'path'       => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'php-thetvdb-api.log',
		]);
		$resolver->setRequired([
			'enabled',
			'level',
			'handler',
		]);
		$resolver->setAllowedTypes('enabled', ['bool']);
		$resolver->setAllowedTypes('level', ['string']);
		$resolver->setAllowedTypes('handler', ['object', 'null']);
		$resolver->setAllowedTypes('path', ['string', 'null']);
		$resolver->setAllowedTypes('subscriber', ['object', 'null']);
		$options = $resolver->resolve(array_key_exists('log', $options) ? $options['log'] : []);
		if ($options['enabled'] && !$options['handler']) {
			$options['handler'] = new StreamHandler(
				$options['path'],
				$options['level']
			);
		}
		return $options;
	}
	/**
	 * Post resolve
	 *
	 * @param array $options
	 */
	protected function postResolve(array $options = [])
	{
		$this->options['base_url'] = sprintf(
			'%s://%s',
			$this->options['secure'] ? self::SCHEME_SECURE : self::SCHEME_INSECURE,
			$this->options['host']
		);
		if (!$this->options['adapter']) {
			$this->options['adapter'] = new GuzzleAdapter(new \GuzzleHttp\Client());
		}
		$this->options['cache'] = $this->configureCacheOptions($options);
		$this->options['log']   = $this->configureLogOptions($options);
	}
}