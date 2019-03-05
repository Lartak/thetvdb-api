<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 00:52
 */

namespace TheTvDb\Exception;


/**
 * Class NotAuthorizedException
 *
 * @package TheTvDb\Exception
 */
class NotAuthorizedException extends ApiException
{
	/**
	 * NotAuthorizedException constructor.
	 *
	 * @param int $code
	 * @param string $message
	 * @param \TheTvDb\Http\Request|null $request
	 * @param \TheTvDb\Http\Response|null $response
	 * @param \Exception|null $previous
	 */
	public function __construct($code, $message, \TheTvDb\Http\Request $request = null, \TheTvDb\Http\Response $response = null, \Exception $previous = null)
	{
		parent::__construct($code, $message, $request, $response, $previous);
	}
}