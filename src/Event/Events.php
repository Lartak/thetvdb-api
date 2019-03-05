<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 04:19
 */

namespace TheTvDb\Event;


/**
 * Class Events
 *
 * @package TheTvDb\Event
 */
final class Events
{
	/** Request */
	const BEFORE_REQUEST = 'thetvdb.before_request';
	const REQUEST        = 'thetvdb.request';
	const AFTER_REQUEST  = 'thetvdb.after_request';
	/** Hydration */
	const BEFORE_HYDRATION = 'thetvdb.before_hydration';
	const HYDRATE          = 'thetvdb.hydrate';
	const AFTER_HYDRATION  = 'thetvdb.after_hydration';
}