<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 04/01/2019
 * Time: 00:56
 */

namespace TheTvDb\Model;


/**
 * Class AbstractModel
 *
 * @package TheTvDb\Model
 */
class AbstractModel
{
	/**
	 * List of properties to populate by the ObjectHydrater
	 *
	 * @var array
	 */
	public static $properties = [];
}