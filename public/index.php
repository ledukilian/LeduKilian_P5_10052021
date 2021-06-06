<?php

use App\Core\Router;

define('ROOT_DIR', realpath(dirname(__DIR__)));
define('CONF_DIR', realpath(dirname(__DIR__)) . '/config');
define('TEMPLATE_DIR', realpath(dirname(__DIR__)) . '/templates');




require_once(ROOT_DIR . '/vendor/autoload.php');

try {
   $config = yaml_parse_file(CONF_DIR."/config.yml");
} catch (\Exception $e) {
   echo "Config not found";
}
try {
   $router = new Router();
   $controller = $router->getRoute();
   $controller->execute();
} catch (\Exception $e) {

}
