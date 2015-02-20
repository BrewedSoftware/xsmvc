<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:19 PM
 */

namespace api\controllers;

abstract class base_controller {

	/**
	 * @var $model string
	 */
	public $format = "html";

	/**
	 * @param $format string
	 * @return \api\controllers\base_controller
	 */
	public static function withFormat($format) {
		$class = get_called_class();
		/** @var $instance base_controller */
		$instance = new $class();
		$instance->format = $format;
		return $instance;
	}

	public function valueOrNullIfNotExists(&$value) {
		return (empty($value) ? null : $value);
	}
}