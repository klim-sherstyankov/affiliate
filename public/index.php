<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers", "origin, x-requested-with, content-type");
header("Access-Control-Allow-Methods", "PUT, GET, POST, DELETE, OPTIONS");
return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
