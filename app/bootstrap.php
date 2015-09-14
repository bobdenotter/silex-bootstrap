<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;
use Silex\Provider\MonologServiceProvider;
use Silex\Provider\WebProfilerServiceProvider;

$app = new Application();

$app->register(new RoutingServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new HttpFragmentServiceProvider());
$app->register(new TwigServiceProvider(), [
    'twig.path'       => dirname(__DIR__).'/view',
    'twig.options' => [
        'debug' => true,
        'cache' => __DIR__ . '/../cache'
    ]
]);

// Load the config, and set it in $app and the templates.
$yaml = new Symfony\Component\Yaml\Parser();

$app['config'] = $yaml->parse(file_get_contents(__DIR__ . '/config.yml'));

// Enable Debug.
if (isset($app['config']['debug']) && $app['config']['debug'] == true) {
    $app['debug'] = true;

    $app->register(new MonologServiceProvider(), [
        'monolog.logfile' => __DIR__ . '/../cache/silex_dev.log',
    ]);

    $app->register(new WebProfilerServiceProvider(), [
        'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    ]);

} else {
    ini_set('display_errors', 0);
}

// Set up DB connection
if (!empty($app['config']['database'])) {
    $app->register(new Silex\Provider\DoctrineServiceProvider(), [
        'db.options'            => [
            'driver'    => 'pdo_mysql',
            'host'      => !empty($app['config']['database']['host'])? $app['config']['database']['host'] : 'localhost',
            'dbname'    => $app['config']['database']['databasename'],
            'user'      => $app['config']['database']['user'],
            'password'  => $app['config']['database']['password'],
        ]
    ]);
}

// Mount the Base Controllers
$app->mount('/', new BaseControllers());

// Create the Twig extensions
$app['twig']->addExtension(new TwigExtension($app));

return $app;
