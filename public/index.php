<?php
session_start();
use App\Core\Router;
use App\Controllers\ErrorController;

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
}
catch (\ConfigException | \DisplayException | \EntityException | \MailException | \SQLException | \TwigException $e) {
   // Affichage ConfigException
}
catch (\Exception | \PDOException $e) {
   $params = [
      'message' => $e->getMessage()
   ];
   $errorController = new ErrorController();
   $errorController->showCriticalError($params);
}
