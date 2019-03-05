<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 04:26
 */

namespace TheTvDb\Event;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheTvDb\Common\ObjectHydrater;
use TheTvDb\Http\HttpClientEventSubscriber;

/**
 * Class HydratationSubscriber
 *
 * @package TheTvDb\Event
 */
class HydratationSubscriber extends HttpClientEventSubscriber
{
	/**
	 * Get subscribed events
	 *
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			Events::HYDRATE => 'hydrate',
		];
	}
	/**
	 * Hydrate the subject with data
	 *
	 * @param HydratationEvent           $event
	 * @param string                   $eventName
	 * @param EventDispatcherInterface $eventDispatcher
	 *
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrate(HydratationEvent $event, $eventName, $eventDispatcher)
	{
		// Possibility to load serialized cache
		$eventDispatcher->dispatch(Events::BEFORE_HYDRATION, $event);
		if ($event->isPropagationStopped()) {
			return $event->getSubject();
		}
		$subject = $this->hydrateSubject($event);
		$event->setSubject($subject);
		// Possibility to cache the data
		$eventDispatcher->dispatch(Events::AFTER_HYDRATION, $event);
		return $event->getSubject();
	}
	/**
	 * Hydrate the subject
	 *
	 * @param  HydratationEvent            $event
	 * @return \TheTvDb\Model\AbstractModel
	 */
	public function hydrateSubject(HydratationEvent $event)
	{
		$objectHydrater = new ObjectHydrater();
		return $objectHydrater->hydrate($event->getSubject(), $event->getData());
	}
}