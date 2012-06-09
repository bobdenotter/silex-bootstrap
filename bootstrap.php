<?php

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/lib.php';

$app = new Silex\Application();

$app['debug'] = true;

$app->register(new Silex\Provider\SessionServiceProvider());

$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile'       => __DIR__.'/debug.log',
    'monolog.class_path'    => __DIR__.'/vendor/monolog/src',
));

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'       => __DIR__.'/view',
    'twig.class_path' => __DIR__.'/vendor/twig/lib',
    'twig.options' => array('debug'=>true), // 'cache' => __DIR__.'/cache',
));

$app['twig']->addExtension(new Twig_Extension_Debug());

$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options'            => array(
        'driver'    => 'pdo_mysql',
        'host'      => '192.168.0.3',  // '62.41.227.122',
        'dbname'    => 'gezondheidsnet',
        'user'      => 'root',
        'password'  => 'Piv87otTgn',
    ),
    'db.dbal.class_path'    => __DIR__.'/vendor/doctrine-dbal/lib',
    'db.common.class_path'  => __DIR__.'/vendor/doctrine-common/lib',
));

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Foutmelding
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
    // $twigvars['trace'] = $e->getTrace();

    $twigvars['title'] = "Een error!";

    return $app['twig']->render('error.twig', $twigvars);

});
