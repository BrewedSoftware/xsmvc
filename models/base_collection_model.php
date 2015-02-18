<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:28 PM
 */

namespace api\models;

abstract class base_collection_model extends base_model implements \Countable {

	/** @var  \api\models\base_model[] */
	public $collection;

	/**
	 * @param $review \api\models\base_model
	 */
	public function add($review) {
		$this->collection[$this->count()] = $review;
	}

	public function count()
	{
		return count($this->collection);
	}
}