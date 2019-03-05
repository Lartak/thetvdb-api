<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 04:22
 */

namespace TheTvDb\Event;


use Symfony\Component\EventDispatcher\Event;
use TheTvDb\Http\Response;
use TheTvDb\Http\Request;
use TheTvDb\Model\AbstractModel;

/**
 * Class HydratationEvent
 *
 * @package TheTvDb\Event
 */
class HydratationEvent extends Event
{
	/**
	 * @var AbstractModel
	 */
	private $subject;
	/**
	 * @var array
	 */
	private $data;
	/**
	 * @var Request|null
	 */
	private $lastRequest;
	/**
	 * @var Response|null
	 */
	private $lastResponse;
	/**
	 * Constructor
	 *
	 * @param AbstractModel $subject
	 * @param array         $data
	 */
	public function __construct(AbstractModel $subject, array $data = [])
	{
		$this->subject = $subject;
		$this->data    = $data;
	}
	/**
	 * @return AbstractModel
	 */
	public function getSubject()
	{
		return $this->subject;
	}
	/**
	 * @param  AbstractModel $subject
	 * @return $this
	 */
	public function setSubject($subject)
	{
		$this->subject = $subject;
		return $this;
	}
	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}
	/**
	 * @param  array $data
	 * @return $this
	 */
	public function setData($data)
	{
		$this->data = $data;
		return $this;
	}
	/**
	 * @return bool
	 */
	public function hasData()
	{
		return !empty($this->data);
	}
	/**
	 * @return Request
	 */
	public function getLastRequest()
	{
		return $this->lastRequest;
	}
	/**
	 * @param  Request|null $lastRequest
	 * @return $this
	 */
	public function setLastRequest($lastRequest)
	{
		$this->lastRequest = $lastRequest;
		return $this;
	}
	/**
	 * @return Response
	 */
	public function getLastResponse()
	{
		return $this->lastResponse;
	}
	/**
	 * @param  Response|null $lastResponse
	 * @return $this
	 */
	public function setLastResponse($lastResponse)
	{
		$this->lastResponse = $lastResponse;
		return $this;
	}
}