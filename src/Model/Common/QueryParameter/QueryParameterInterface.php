<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:24
 */

namespace TheTvDb\Model\Common\QueryParameter;


/**
 * Interface QueryParameterInterface
 *
 * @category TheTvDb
 * @package TheTvDb\Model\Common\QueryParameter
 * @author Lartak
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface QueryParameterInterface
{
	/**
	 * @return string
	 */
	public function getKey();
	/**
	 * @return string
	 */
	public function getValue();
}