<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 01:54
 */

namespace TheTvDb;


/**
 * Class Token
 *
 * @package TheTvDb
 */
class Token
{
	const TOKEN_DURATION = '24 HOURS';
	/**
	 * @var string
	 */
	private $token = null;
	/**
	 * @var \DateTime
	 */
	private $createdAt;
	/**
	 * @var \DateTime
	 */
	private $expiresAt;
	/**
	 * @var boolean
	 */
	private $success;
	/**
	 * Token bag
	 *
	 * @param $token
	 */
	public function __construct($token = null)
	{
		$this->token = $token;
	}
	/**
	 * @param  string|null  $token
	 * @return $this
	 */
	public function setToken($token)
	{
		$this->token = $token;
		return $this;
	}
	/**
	 * @return string|null
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param  \DateTime|string $start
	 * @return $this
	 * @throws \Exception
	 */
	public function setCreatedAt($start)
	{
		if (!$start instanceof \DateTime) {
			$start = new \DateTime($start);
		}
		$this->createdAt = $start;
		$this->setExpiresAt();
		return $this;
	}
	/**
	 * @return \DateTime
	 */
	public function getCreatedAt()
	{
		return $this->createdAt;
	}

	protected function setExpiresAt()
	{
		$createdAt = clone $this->createdAt;
		$this->expiresAt = $createdAt->add(
			\DateInterval::createfromdatestring('+' . self::TOKEN_DURATION)
		);
	}
	/**
	 * @return \DateTime
	 */
	public function getExpiresAt()
	{
		if (is_null($this->expiresAt)) {
			$this->setExpiresAt();
		}
		return $this->expiresAt;
	}
	/**
	 * @param  boolean $success
	 * @return $this
	 */
	public function setSuccess($success)
	{
		$this->success = $success;
		return $this;
	}
	/**
	 * @return boolean
	 */
	public function getSuccess()
	{
		return $this->success;
	}

	/**
	 * @return bool
	 * @throws \Exception
	 */
	public function isExpired()
	{
		return (new \DateTime())->getTimestamp() > $this->expiresAt->getTimestamp();
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return (string)$this->token;
	}
}