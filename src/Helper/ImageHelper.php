<?php
/**
 * Created by PhpStorm.
 * User: Lartak
 * Date: 06/01/2019
 * Time: 18:36
 */

namespace TheTvDb\Helper;


use TheTvDb\Model\Episode;
use TheTvDb\Model\Series;

/**
 * Class ImageHelper
 *
 * @package TheTvDb\Helper
 */
class ImageHelper extends Helper
{

	const BANNER_PREFIX = 'banners';

	/**
	 * @param string|\TheTvDb\Model\AbstractModel $path
	 * @return string
	 */
	public function url($path)
	{
		return $this->_url($path);
	}

	/**
	 * @param string|\TheTvDb\Model\AbstractModel $path
	 * @param array $options
	 * @return string
	 */
	public function html($path, $options = [])
	{
		if ($path instanceof Series) {
			if (!strlen($path->getBanner())) {
				$options = array_merge($options, ['alt' => $path->getSeriesName()]);
			}
		} elseif ($path instanceof Episode) {
			if (!strlen($path->getFilename())) {
				$options = array_merge($options, ['alt' => $path->getName()]);
			}
		} elseif ($path instanceof Series\Actor) {
			if (!strlen($path->getImage()->getPath())) {
				$options = array_merge($options, ['alt' => htmlspecialchars($path->getName())]);
			}
		}
		return $this->_image($this->_url($path), $options);
	}

	/**
	 * @param string $type
	 * @return string
	 */
	public function placeholder($type)
	{
		if ($type === 'actor') {
			return 'https://www.thetvdb.com/application/themes/thetvdb/images/default_person.jpg';
		}
		return '';
	}

	/**
	 * @param string|\TheTvDb\Model\AbstractModel $uri
	 * @param array $options
	 * @return string
	 */
	private function _image($uri, $options = [])
	{
		$options = array_merge(['src' => $uri], $options);
		return $this->_html($options, null, 'img');
	}

	/**
	 * @param string|\TheTvDb\Model\AbstractModel $path
	 * @return string
	 */
	private function _url($path)
	{
		$baseUri = self::BASE_URI;
		$prefix = self::BANNER_PREFIX;
		if ($path instanceof Series) {
			if (method_exists($path, 'getBanner')) {
				$path = $path->getBanner();
				$prefix = self::BANNER_PREFIX;
			}
		} elseif ($path instanceof Episode) {
			$path = $path->getFilename();
		} elseif ($path instanceof Series\Actor) {
			if (!strlen($path->getImage()->getPath())) {
				if (empty($this->parameters['placeholderActor'])) {
					$prefix = 'application/themes/thetvdb/images';
					$path = 'default_person.jpg';
				} else {
					return $this->parameters['placeholderActor'];
				}
			} else {
				$path = $path->getImage()->getPath();
			}
		}
		return sprintf('%s/%s/%s', $baseUri, $prefix, $path);
	}
}