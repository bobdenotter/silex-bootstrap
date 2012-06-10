<?php

if (!file_exists(__DIR__.'/config.php')) {
    echo "<p>The file <tt>config.php</tt> doesn't exist. Copy <tt>config.php.dist</tt> to <tt>config.php</tt> and add the correct settings.</p>";
    die();
}

if (!file_exists(__DIR__.'/vendor/autoload.php')) {
    echo "<p>The file <tt>vendor/autoload.php</tt> doesn't exist. Make sure you've installed the Silex components with Composer. See the README.md file.</p>";
    die();
}

require_once __DIR__.'/config.php';
require_once __DIR__.'/bootstrap.php';
require_once __DIR__.'/vendor/autoload.php';
require_once __DIR__.'/app.php';
require_once __DIR__.'/lib.php';

$app->run();
