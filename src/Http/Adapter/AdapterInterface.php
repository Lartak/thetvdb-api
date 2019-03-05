<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 04:37
 */

namespace TheTvDb\Http\Adapter;


use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use TheTvDb\Exception\ApiException;
use TheTvDb\Http\Request;
use TheTvDb\Http\Response;

/**
 * Interface AdapterInterface
 *
 * @category TheTvDb
 * @package TheTvDb\Http\Adapter
 * @author Lartak
 * @license http://opensource.org/licenses/MIT The MIT License (MIT)
 */
interface AdapterInterface
{
	/**
	 * Compose a GET request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function get(Request $request);
	/**
	 * Send a HEAD request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function head(Request $request);
	/**
	 * Compose a POST request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function post(Request $request);
	/**
	 * Send a PUT request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function put(Request $request);
	/**
	 * Send a DELETE request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function delete(Request $request);
	/**
	 * Send a PATCH request
	 *
	 * @throws ApiException
	 * @param  Request          $request
	 * @return Response
	 */
	public function patch(Request $request);
	/**
	 * Return the used client
	 *
	 * @return mixed
	 */
	public function getClient();
	/**
	 * Register any specific subscribers
	 *
	 * @param  EventDispatcherInterface $eventDispatcher
	 * @return void
	 */
	public function registerSubscribers(EventDispatcherInterface $eventDispatcher);
}