<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:25 PM
 */

namespace api\models;

abstract class base_model {

	public function get_class()
	{
		try {
			$class = get_class($this);
		} catch (\Exception $e) {
			throw new \Exception('Not a Class!');
		}
		return $class;
	}
}