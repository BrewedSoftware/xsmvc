<?php
/**
 * Created by PhpStorm.
 * User: mdemaso
 * Date: 1/12/15
 * Time: 9:03 PM
 */

namespace api\views;

abstract class base_view {
  public $format = "html";

  public function __construct($format) {
    $this->format = $format;
  }

	/**
	 * @param $model \api\models\base_model
	 */
	public function response(&$model){
		if ($this->format == 'json') {
      header('Content-Type: application/json');
			echo json_encode($model);
			return;
		} ?>
		<html>
			<head>
				<?php $this->head(); ?>
			</head>
			<body class="full_width">
				<div id="wrapper" class="full_width">
					<div id="header" class="full_width">
						<?php $this->header($model); ?>
					</div>
					<div id="content" class="full_width">
						<?php $this->content($model); ?>
					</div>
					<div id="footer" class="full_width">
						<?php $this->footer($model); ?>
					</div>
				</div>
				<div data-role="collapsible">
					<h4>Session and Model</h4>
		      <pre><?php print_r($_SESSION); ?></pre>
		      <pre><?php print_r($model); ?></pre>
				</div>
			</body>
		</html>
	<?php }

	public function head() { ?>
		<title>API</title>
		<style>
			html, body, div, span {border: 0; padding: 0; margin: 0;}
		</style>
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<meta http-equiv="content-type" content="text/html; charset=UTF-8"/>

		<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
	<?php }

	public function header(&$model){ ?>
		<div id="site_title">
			<h1>
				API Model: <?php get_class($model); ?>
			</h1>
		</div>
  <?php }

	public function footer(&$model){ ?>
		<div id="site_title">
			<h1>
				API Model: <?php get_class($model); ?>
			</h1>
		</div>
		<script defer type='application/javascript' src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
		<script defer type='application/javascript' src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
	<?php }

	public function currentPage() {
		return '/api/'.$_REQUEST['request'].'.html';
	}

	public function linkGenerator($controller = "home", $action = "display", $arguments = array(), $format = "html", $text = null, $button = true, $mini = true) {
		$link = '/api/'.$controller.'/'.$action;

		for ($i = 0; $i < count($arguments); $i = $i +2) {
			$link = $link.'/'.$arguments[$i].'/'.$arguments[$i+1];
		}

		$link = $link.'.'.$format;

		$button_html = '';

		if ($button) {
			$button_html = $button_html.' data-role="button" data-inline="true"';
		}

		if ($mini) {
			$button_html = $button_html.' data-mini="true"';
		}

		if (is_null($text)) {
			$link = '<a href="'.$link.'" data-ajax="false"'.$button_html.'>'.ucfirst($action).'</a>';
		} else {
			$link = '<a href="'.$link.'" data-ajax="false"'.$button_html.'>'.$text.'</a>';
		}

		return $link;
	}

  abstract public function content(&$model);
}