<?php

require_once __DIR__.'/vendor/autoload.php';

use \Michelf\Markdown;
use \Drola\LogReader\ReaderFactory;

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
    $logs = array();
    foreach($app['logs'] as $l) {
        $reader = ReaderFactory::getReader($l[0], $l[1]);
        $log = array('title'=>$l[2], 'lines'=>array());
        $i = 0;
        while($reader->valid() && $i<10) {
            $log['lines'][] = $reader->current();
            $i++;
            $reader->next();
        }
        $logs[] = $log;
    }

	return $app['twig']->render('index.twig', array(
        'logs' => $logs,
		'dirs' => array_map(function($i) use ($app) { return str_replace($app['document_root'], '', $i); },
			scandir($app['document_root'])),
		'text' => Markdown::defaultTransform(file_get_contents($app['index']))));
});

$app->get('/browse/{path}', function(Silex\Application $app, $path) use($app) {
    $root = realpath($app['document_root']);
    $path = realpath($root.'/'.$path);

    //Security
    if(strpos($path, $root) !== 0) {
        $app->abort(404, "Not found.");
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    return $app->json(array_map(function($i) use ($finfo, $path) {
        $filename = $path.'/'.$i;
        $info = array();
        $info['name'] = $i;
        $info['mime'] = finfo_file($finfo, $filename);
        $info['size'] = filesize($filename);
        return $info;
    }, scandir($path)));
})->assert('path', '.+');

return $app;