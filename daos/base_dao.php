<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:38 PM
 */

namespace api\daos;

use PDO;
use PDOException;

abstract class base_dao {
	/**
	 * @var PDO
	 */
	public $connection;

	abstract public function create(&$model);

	abstract public function retrieve(&$model);

	abstract public function update(&$model);

	abstract public function delete(&$model);

	public function __construct()
	{
		$dsn = 'mysql:dbname=test;host=localhost';
		$user = 'mysqluser';
		$password = 'password';

		try {
			$this->connection = new PDO($dsn, $user, $password);
		} catch (PDOException $e) {
			echo 'Connection failed: ' . $e->getMessage();
		}
	}

	/**
	 * @param $sql string
	 * @param $class string
	 *
	 * @return mixed
	 */
	public function query($sql, $class)
	{
		$statement = $this->connection->query($sql);
		$model_array = $statement->fetchAll(PDO::FETCH_CLASS, $class);
		$statement->closeCursor();
		foreach ($model_array as $model) {
			return $model;
		}
		$model = new $class();
		return $model;
	}

	public function exec($sql)
	{
		return $this->connection->exec($sql);
	}

	public function lastInsertId($name = null)
	{
		return $this->connection->lastInsertId($name);
	}

	public function nullOrQuote($value) {
		if (empty($value)) {
			return "NULL";
		} else {
			return $this->connection->quote($value);
		}
	}

	public function nullOrValue($value) {
		if (empty($value)) {
			return "NULL";
		} else {
			return $value;
		}
	}

	public function startsWith($haystack, $needle)
	{
		$length = strlen($needle);
		return (substr($haystack, 0, $length) === $needle);
	}

}
