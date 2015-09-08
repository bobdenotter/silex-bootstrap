<?php

$app['twig']->addFunction(new \Twig_SimpleFunction('asset', function ($asset) use ($app)
    {
        return $app['request_stack']->getMasterRequest()->getBasepath().'/'.ltrim($asset, '/');
    }
));

$app['twig']->addFunction(new \Twig_SimpleFunction('dump', function ($var) use ($app)
    {
        if ($app['config']['debug']) {
            dump($var);
        }
    }
));

