<?php

require "bootstrap.php";

/**
 * "root"
 */
$app->get("/", function(Silex\Application $app) {

    $twigvars = array();

    $twigvars['title'] = "Gezondheidsnet - Zakwoordenboekje - Si!";

    $tempgroups = $app['db']->fetchAll('SELECT DISTINCT groupname FROM  `woorden` ORDER BY groupname LIMIT 0 , 100');


    foreach($tempgroups as $group) {
        $groups[ makeURI($group['groupname']) ] = $group['groupname'];
    }

    $twigvars['groups'] = $groups;
    
    $twigvars['words'] = $app['db']->fetchAll('SELECT * FROM  `woorden` ORDER BY nl');

    
    
    return $app['twig']->render('index.twig', $twigvars);


});



$app->run();
