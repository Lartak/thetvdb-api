<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 05/01/2019
 * Time: 04:39
 */

namespace TheTvDb\Http\Adapter;


use TheTvDb\Exception\ApiException;
use TheTvDb\Http\Request;
use TheTvDb\Http\Response;

/**
 * Class AbstractAdapter
 *
 * @package TheTvDb\Http\Adapter
 */
abstract class AbstractAdapter implements AdapterInterface
{
	/**
	 * Create the unified exception to throw
	 *
	 * @param  Request          $request
	 * @param  Response         $response
	 * @param \Exception        $previous
	 * @return ApiException
	 */
	protected function createApiException(Request $request, Response $response, \Exception $previous= null)
	{
		$errors = json_decode((string)$response->getBody());
		return new ApiException(
			isset($errors->status_code) ? $errors->status_code : $response->getCode(),
			isset($errors->status_message) ? $errors->status_message : null,
			$request,
			$response,
			$previous
		);
	}
}