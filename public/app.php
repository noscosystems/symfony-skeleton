<?php

use Symfony\Component\ClassLoader\ApcClassLoader;
use Symfony\Component\HttpFoundation\Request;

$loader = require_once __DIR__.'/../app/bootstrap.php.cache';
// If you need to make changes to the parameters in an emergency, but don't want to change the configuration parameters
// (those values may be specific to the current installation) then add "PARAMETER=VALUE" pairs (one per line) to the
// ".env" file in the parent directory in the External Parameter format:
//     http://symfony.com/doc/current/cookbook/configuration/external_parameters.html
// Remember that if you make any changes to that file (including deletion), you need to clear the cache!
file_exists(__DIR__ . '/../.env') && Dotenv::load(__DIR__ . '/../', '.env');

// Enable APC for autoloading to improve performance. You should change the ApcClassLoader first argument to a unique
// prefix in order to prevent cache key conflicts with other applications also using APC.
# $apcLoader = new ApcClassLoader(sha1(__FILE__), $loader);
# $loader->unregister();
# $apcLoader->register(true);

require_once __DIR__ . '/../app/AppKernel.php';
# require_once __DIR__ . '/../app/AppCache.php';

$kernel = new AppKernel('prod', false);
$kernel->loadClassCache();
# $kernel = new AppCache($kernel);

// When using the HttpCache, you need to call the method in your front controller instead of relying on the
// configuration parameter.
# Request::enableHttpMethodParameterOverride();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
