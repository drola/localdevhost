<?php

require_once __DIR__.'/vendor/autoload.php';

use \Michelf\Markdown;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(),
	array('twig.path' => __DIR__.'/views')
);

$app->before(function () use ($app) {
	$app['twig']->addGlobal('layout', null);
	$app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
	$app['twig']->addGlobal('home', $app['home']);
	$app['twig']->addGlobal('assets', $app['assets_dir']);
});

$app->get('/', function() use ($app) {
	return $app['twig']->render('index.twig', array('text' => Markdown::defaultTransform(file_get_contents($app['document_root'].'/EXAMPLE.md'))));
});

return $app;