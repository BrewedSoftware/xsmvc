<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 8:15 PM
 */

namespace api;

spl_autoload_register(function ($class_name)
	{
		$file_extension = ".php";
		$class_name_clean = explode('\\', $class_name);
		if (count($class_name_clean) > 1) {
			$class_name = $class_name_clean[count($class_name_clean)-1];
		}
		$class_name_parts = explode('_', $class_name);
		include_once('./'.$class_name_parts[count($class_name_parts)-1].'s/'.$class_name.$file_extension);
	}
);

error_reporting(E_ALL);
ini_set('display_errors', 'on');

$requested_controller = 'error';
$requested_action = 'e404';
$get_array = array();

session_start();

if (isset($_REQUEST['request'])) {
	$arg_array = explode('/', $_REQUEST['request']);
	$i = 0;
	while ($i < count($arg_array)) {
		switch ($i) {
			case 0:
				$requested_controller = $arg_array[$i];
				$i++;
				break;
			case 1:
				$requested_action = $arg_array[$i];
				$i++;
				break;
			default:
				$get_array[$arg_array[$i]] = $arg_array[$i+1];
				$i = $i + 2;
		}
	}
}

$post_array = json_decode(file_get_contents("php://input"), true);
if (!empty($post_array)) {
	$request_array = array_merge($get_array, $post_array);
} else {
	$request_array = $get_array;
}

$requested_controller_name = 'api\\controllers\\'.$requested_controller.'_controller';

try {
	/** @var $controller \api\controllers\base_controller */
	$controller = new $requested_controller_name();

	if (!method_exists($controller, $requested_action)) {
		echo 'Action not found: '.$requested_action;
		die();
	}

	if (isset($_REQUEST['format'])) {
		$controller->format = $_REQUEST['format'];
	} else {
		$controller->format = 'html';
	}

	$controller->$requested_action($request_array);
} catch (\Exception $e) {
	echo 'Could not create instance of class: '.$requested_controller_name.' because: '.$e;
}