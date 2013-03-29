<?php

$app = require 'backend/bootstrap.php';
$app['document_root'] = __DIR__.'/../';
$app['index'] = __DIR__.'/EXAMPLE.md';
$app['assets_dir'] = "/localdevhost/";
$app['home'] = "/localdevhost/";
$app['logs'] = array(
    array('/var/log/apache2/error.log', 'apache/error.log', "Error Log")
    );
$app->run();