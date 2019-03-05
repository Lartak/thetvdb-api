<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 18:59
 */

namespace TheTvDb\Helper;


/**
 * Class Helper
 *
 * @package TheTvDb\Helper
 */
class Helper
{
	const BASE_URI = 'https://www.thetvdb.com';

	private $balisesNotContent = [
		'img'
	];

	public $parameters = [];

	/**
	 * Helper constructor.
	 *
	 * @param array $params
	 */
	public function __construct(array $params = [])
	{
		if (!empty($params)) {
			if (!empty($params['placeholderActor'])) {
				$this->parameters['placeholderActor'] = $params['placeholderActor'];
			}
		}
	}

	/**
	 * @return \TheTvDb\Helper\ImageHelper
	 */
	public function imageHelper()
	{
		return new ImageHelper();
	}

	/**
	 * @param $options
	 * @param null $content
	 * @param string $tag
	 * @return string
	 */
	protected function _html($options, $content = null, $tag = 'a')
	{
		$_options = [];
		$html = "<$tag ";
		foreach ($options as $key => $value)
		{
			$_options[] = sprintf('%s=%s', $key, $value);
		}
		$html .= implode(' ', $_options);
		if (in_array($tag, $this->balisesNotContent)) {
			$html .= ' />';
		} else {
			$html .= ' >';
			$html .= !is_null($content) ? $content : '';
			$html .= "</$tag>";
		}
		return $html;
	}
}