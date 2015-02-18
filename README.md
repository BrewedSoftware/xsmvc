# xsmvc
An eXtremely Simple MVC starter for PHP and MySQL

##Getting Started
###Server Setup
The standard setup for the server is a *LAMP stack*. Linux OS, Apache Server, MySQL, and PHP. These are free software and a fairly common setup for simple websites.

###Apache Setup
Allow Apache to use .HTACCESS files in subfolders to override the global settings. This lets Human and SEO URLS be translated into a URL the *dispathcer.php* can use. Example: /mvc/article/show/id/1234.html to /mvc/dispatcher.php?controller=article&action=show&format=html&request=id/1234

###What this MVC Framework is good for
It is good for create a very simple API that needs to output both an HTML and JSON version of the same data. This allows for the two consumers of the data (the browser or JSON consumer) to use the same logic.

###Create Your First Model
Here we are creating a simple model to hold a string as "data".
```php
// models\test_model.php
<?php
namespace api\models;

class test_model extends base_model {
  /** @var string */
  public $data;
}
?>
```

###Create Your First View
Here we are taking api\models\test_model->data and echoing it out to the stream.
```php
// views\test_view.php
<?php
namespace api\views;

class test_view extends base_view {
  /**
   * @param $model \api\models\test_model
   */
  public function content(&$model){
    echo $model->data;
  }
}
?>
```

###Create Your First Controller
Here comes linking the model and the view together in the controller. We create a *test* controller with a *show* action. The show action takes the input data and places it into the model and then gets a view and prints it out.
```php
// controllers\test_controller.php
<?php
namespace api\controllers;

use api\models\test_model;
use api\views\test_view;

class test_controller extends base_controller {
  public function show($request_array = null) {
    $model = new test_model();
    $model->data = $request_array['data'];
    
    $view = new test_view();
    $view->response($model);
  }
}
?>
```
