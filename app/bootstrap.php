<?php

use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Silex\Provider\RoutingServiceProvider;
use Silex\Provider\ValidatorServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Silex\Provider\HttpFragmentServiceProvider;

$app = new Application();
$app->register(new RoutingServiceProvider());
$app->register(new ValidatorServiceProvider());
$app->register(new ServiceControllerServiceProvider());
$app->register(new TwigServiceProvider(), array(
    'twig.path'       => dirname(__DIR__).'/view',
    'twig.options' => array(
        'debug' => true,
        'cache' => __DIR__ . '/../cache'
    )
));
$app->register(new HttpFragmentServiceProvider());

$app['twig'] = $app->extend('twig', function ($twig, $app) {
    // add custom globals, filters, tags, ...

    $twig->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app) {
            return $app['request_stack']->getMasterRequest()->getBasepath().'/'.ltrim($asset, '/');
        }
    ));

    $twig->addFunction(new \Twig_SimpleFunction('dump', function ($var) {
            dump($var);
        }
    ));

    return $twig;
});

// Enable Debug.
$app['debug'] = true;

// Load the config, and set it in $app and the templates.
$yaml = new Symfony\Component\Yaml\Parser();

$app['config'] = $yaml->parse(file_get_contents(__DIR__ . '/config.yml'));
$app['twig']->addGlobal('config', $app['config']);

return $app;


// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Response;

// $app = new Silex\Application();

// $app['debug'] = true;

// $yaml = new Symfony\Component\Yaml\Parser();

// $app['config'] = $yaml->parse(file_get_contents(__DIR__ . '/config.yml'));

// // dump($app['config']);

// $app->register(new Silex\Provider\SessionServiceProvider());

// $app->register(new Silex\Provider\MonologServiceProvider(), array(
//     'monolog.logfile'       => __DIR__.'/debug.log',
// ));

// $app->register(new Silex\Provider\RoutingServiceProvider());
// $app->register(new Silex\Provider\ServiceControllerServiceProvider());
// $app->register(new Silex\Provider\UrlGeneratorServiceProvider());
// $app->register(new Silex\Provider\HttpFragmentServiceProvider());

// $app->register(new Silex\Provider\TwigServiceProvider(), array(
//     'twig.path'       => dirname(__DIR__).'/view',
//     'twig.options' => array(
//         'debug' => true,
//         'cache' => __DIR__ . '/../cache'
//     )
// ));

// $app['twig']->addGlobal('config', $app['config']);

// $app->register(new Silex\Provider\WebProfilerServiceProvider(), array(
//     'profiler.cache_dir' => __DIR__ . '/../cache',
// ));



// // $webProfilerPath = __DIR__ . '/../vendor/symfony/web-profiler-bundle/Symfony/Bundle/WebProfilerBundle/Resources/views';
// // $app['twig.loader.filesystem']->addPath($webProfilerPath, 'WebProfiler');




// $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
//     'db.options'            => array(
//         'driver'    => 'pdo_mysql',
//         'host'      => $app['config']['database']['host'],
//         'dbname'    => $app['config']['database']['databasename'],
//         'user'      => $app['config']['database']['user'],
//         'password'  => $app['config']['database']['password'],
//     )
// ));

// /**
//  * Custom Twig functions
//  */
// $app['twig']->addFunction(new Twig_SimpleFunction('dump',
//     function ($var) {
//         dump($var);
//     }
// ));

/**
 * Error handling
 */
$app->error(function(Exception $e) use ($app) {

    $app['monolog']->addError(json_encode(array(
        'class' => get_class($e),
        'message' => $e->getMessage(),
        'code' => $e->getCode(),
        'trace' => $e->getTrace()
        )));

    $twigvars = array();

    $twigvars['class'] = get_class($e);
    $twigvars['message'] = $e->getMessage();
    $twigvars['code'] = $e->getCode();

	$trace = $e->getTrace();;

	unset($trace[0]['args']);

    $twigvars['trace'] = $trace[0];

    $twigvars['title'] = "An error has occured!";

    return $app['twig']->render('error.twig', $twigvars);

});
