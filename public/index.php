<?php
define('CONF_DIR', realpath(dirname(__DIR__)) . '/config');

try {
   $config = Yaml::parseFile(CONF_DIR."/config.yml");
} catch (\Exception $e) {
   echo "Config not found";
}
try {
   $router = new Router();
   $controller = $router->getRoute();
   $controller->execute();
} catch (\Exception $e) {

}

