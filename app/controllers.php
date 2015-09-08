<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * "root"
 */
$app->get("/", function(Silex\Application $app)
{

    $twigvars = [];

    $twigvars['title'] = "Silex skeleton app";

    $twigvars['content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.";

    return $app['twig']->render('index.twig', $twigvars);


})
->bind('homepage');



// $app->error(function (\Exception $e, Request $request, $code) use ($app)
// {
//     if ($app['debug']) {
//         return;
//     }

//     // 404.html, or 40x.html, or 4xx.html, or error.html
//     $templates = [
//         'errors/'.$code.'.html.twig',
//         'errors/'.substr($code, 0, 2).'x.html.twig',
//         'errors/'.substr($code, 0, 1).'xx.html.twig',
//         'errors/default.html.twig',
//     ]);

//     return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
// });

