<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 00:52
 */

namespace TheTvDb\Exception;


use TheTvDb\Http\Request;
use TheTvDb\Http\Response;

/**
 * Class ApiException
 *
 * @package TheTvDb\Exception
 */
class ApiException extends \Exception
{

	const STATUS_SUCCESS = 200;
	const STATUS_NOT_AUTHORIZED = 401;
	const STATUS_NOT_FOUND = 404;
	const STATUS_RECORD_NOT_UPDATED = 409;
	/**
	 * @var Request
	 */
	protected $request;
	/**
	 * @var Response
	 */
	protected $response;
	/**
	 * Create the exception
	 *
	 * @param int $code
	 * @param string $message
	 * @param Request|null $request
	 * @param Response|null $response
	 * @param \Exception|null $previous
	 */
	public function __construct($code, $message, $request = null, $response = null, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->request  = $request;
		$this->response = $response;
	}
	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}
	/**
	 * @param  Request $request
	 * @return $this
	 */
	public function setRequest($request)
	{
		$this->request = $request;
		return $this;
	}
	/**
	 * @return Response
	 */
	public function getResponse()
	{
		return $this->response;
	}
	/**
	 * @param  Response $response
	 * @return $this
	 */
	public function setResponse($response)
	{
		$this->response = $response;
		return $this;
	}
}