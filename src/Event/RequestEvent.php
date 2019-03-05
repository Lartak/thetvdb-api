<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 05:18
 */

namespace TheTvDb\Event;


use Symfony\Component\EventDispatcher\Event;
use TheTvDb\Common\ParameterBag;
use TheTvDb\Http\Request;
use TheTvDb\Http\Response;

/**
 * Class RequestEvent
 *
 * @package TheTvDb\Event
 */
class RequestEvent extends Event
{
	/**
	 * @var Request
	 */
	private $request;
	/**
	 * @var Response
	 */
	private $response;
	/**
	 * Construct the request event
	 *
	 * @param Request $request
	 */
	public function __construct(Request $request)
	{
		$this->request = $request;
	}
	/**
	 * @return ParameterBag
	 */
	public function getParameters()
	{
		return $this->request->getParameters();
	}
	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->request->getPath();
	}
	/**
	 * @return string
	 */
	public function getMethod()
	{
		return $this->request->getMethod();
	}
	/**
	 * @return ParameterBag
	 */
	public function getHeaders()
	{
		return $this->request->getHeaders();
	}
	/**
	 * @return null
	 */
	public function getBody()
	{
		return $this->request->getBody();
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
	 * @return string
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
	/**
	 * @return bool
	 */
	public function hasResponse()
	{
		return null !== $this->response;
	}
}