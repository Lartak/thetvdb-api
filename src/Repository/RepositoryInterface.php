<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 11:26
 */

namespace TheTvDb\Repository;


use TheTvDb\Api\ApiInterface;
use TheTvDb\Factory\AbstractFactory;

/**
 * Interface RepositoryInterface
 *
 * @category TheTvDb
 * @package TheTvDb\Repository
 * @author Lartak
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface RepositoryInterface
{
	/**
	 * Return the API Class
	 *
	 * @return ApiInterface
	 */
	public function getApi();
	/**
	 * Return the Factory Class
	 *
	 * @return AbstractFactory
	 */
	public function getFactory();
}