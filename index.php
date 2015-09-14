<?php

if (!file_exists(__DIR__.'/app/config.yml')) {
    echo "<p>The file <tt>app/config.yml</tt> doesn't exist. Copy <tt>config.yml.dist</tt> to <tt>config.yml</tt> and add the correct settings.</p>";
    die();
}

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "<p>The file <tt>vendor/autoload.php</tt> doesn't exist. Make sure you've installed the Silex components with Composer. See the README.md file.</p>";
    die();
}

require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/app/controllers.php';
require_once __DIR__.'/app/twig_extensions.php';
require_once __DIR__.'/app/lib.php';

$app = require_once __DIR__.'/app/bootstrap.php';

$app->run();
