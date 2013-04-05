<?php

$app = require 'backend/bootstrap.php';

//Directory exposed by browser
$app['document_root'] = __DIR__.'/../';

//Home page
$app['index'] = __DIR__.'/EXAMPLE.md';

//Relative path to the assets (js/img/css)
$app['assets_dir'] = "/localdevhost/";

//Relative path to the homepage, usually same as $app['assets']
$app['home'] = "/localdevhost/";

//Logs that you want to display. Must have read aceess.
$app['logs'] = array(
    //array('/var/log/apache2/error.log', 'apache/error.log', "Error Log")
    );
$app->run();