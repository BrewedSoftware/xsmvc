<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:46 PM
 */

namespace api\daos;

use PDO;
use PDOException;

abstract class base_collection_dao extends base_dao {
	public function query($sql, $class)
	{
		$model_array = array();
		try {
			$statement = $this->connection->query($sql);
			$model_array = $statement->fetchAll(PDO::FETCH_CLASS, $class);
			$statement->closeCursor();
		} catch (PDOException $e) {
			echo 'Query failed: ' . $e->getMessage();
		}
		return $model_array;
	}
}