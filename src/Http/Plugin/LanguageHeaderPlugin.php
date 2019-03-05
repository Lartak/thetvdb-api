<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:16
 */

namespace TheTvDb\Http\Plugin;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use TheTvDb\Event\Events;
use TheTvDb\Event\RequestEvent;

/**
 * Class LanguageHeaderPlugin
 *
 * @package TheTvDb\Http\Plugin
 */
class LanguageHeaderPlugin implements EventSubscriberInterface
{
	/**
	 * @var string
	 */
	private $language;

	/**
	 * TokenHeaderPlugin constructor.
	 *
	 * @param string $language
	 */
	public function __construct($language)
	{
		$this->language = $language;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			Events::BEFORE_REQUEST => 'onBeforeSend'
		];
	}

	/**
	 * @param \TheTvDb\Event\RequestEvent $event
	 */
	public function onBeforeSend(RequestEvent $event)
	{
		$event->getRequest()->getHeaders()->set('Accept-Language', $this->language);
	}
}