<?php

use Nur\Kernel\Application;

$app = new Application;

define('NUR_VERSION', Application::VERSION);
define('APP_ENV', strtolower(config('app.env')));

return $app;
