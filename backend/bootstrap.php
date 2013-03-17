<?php

require_once __DIR__.'/vendor/autoload.php';

use \Michelf\Markdown;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(),
	array('twig.path' => __DIR__.'/views')
);

$app->before(function () use ($app) {
	$app['twig']->addGlobal('layout', $app['twig']->loadTemplate('layout.twig'));
	$app['twig']->addGlobal('home', $app['home']);
	$app['twig']->addGlobal('assets', $app['assets_dir']);
});

$app->get('/', function() use ($app) {
	return $app['twig']->render('index.twig', array(
		'dirs' => array_map(function($i) use ($app) { return str_replace($app['document_root'], '', $i); },
			scandir($app['document_root'])),
		'text' => Markdown::defaultTransform(file_get_contents($app['index']))));
});

return $app;