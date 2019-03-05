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
use TheTvDb\Token;

/**
 * Class TokenHeaderPlugin
 *
 * @package TheTvDb\Http\Plugin
 */
class TokenHeaderPlugin implements EventSubscriberInterface
{
	/**
	 * @var \TheTvDb\Token
	 */
	private $token;

	/**
	 * TokenHeaderPlugin constructor.
	 *
	 * @param \TheTvDb\Token $token
	 */
	public function __construct(Token $token)
	{
		$this->token = $token;
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
		$event->getRequest()->getHeaders()->set(
			'Authorization',
			sprintf('Bearer %s', $this->token->getToken())
		);
	}
}