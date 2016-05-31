<?php

$basedir = dirname(__DIR__);

if (!file_exists($basedir . '/app/config.yml')) {
    echo "<p>The file <tt>app/config.yml</tt> doesn't exist. Copy <tt>config.yml.dist</tt> to <tt>config.yml</tt> and add the correct settings.</p>";
    die();
}

if (!file_exists($basedir . '/vendor/autoload.php')) {
    echo "<p>The file <tt>vendor/autoload.php</tt> doesn't exist. Make sure you've installed the Silex components with Composer. See the README.md file.</p>";
    die();
}

require_once $basedir . '/vendor/autoload.php';
require_once $basedir . '/app/controllers.php';
require_once $basedir . '/app/twig_extensions.php';
require_once $basedir . '/app/lib.php';

$app = require_once $basedir . '/app/bootstrap.php';

$app->run();
