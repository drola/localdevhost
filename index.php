<?php

$app = require 'backend/bootstrap.php';
$app['document_root'] = __DIR__;
$app['assets_dir'] = "/localdevhost/web";
$app['home'] = "/localdevhost/";
$app->run();