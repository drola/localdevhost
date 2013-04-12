<?php

require_once __DIR__.'/vendor/autoload.php';

use \Michelf\Markdown;
use \Drola\LogReader\ReaderFactory;

$app = new Silex\Application();

$app->register(new Silex\Provider\TwigServiceProvider(),
	array('twig.path' => __DIR__.'/views')
);

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

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

    //Initialize mime type lookup
    $finfo = finfo_open(FILEINFO_MIME_TYPE);

    //If this is text file, show it's contents
    $text_cnt = "";
    $filename = "";
    if(is_file($path) && preg_match("/$text/", finfo_file($finfo, $path))) {
        $filename = basename($path);
        $text_cnt = file_get_contents($path);
        $path = dirname($path);
    }

    //README.md
    $readme = "";
    if(file_exists($path.'/README.md')) {
        $readme = Markdown::defaultTransform(file_get_contents($path.'/README.md'));
    }

    return $app->json(array(
        'path'=>str_replace($root, "", $path) | "/",
        'readme'=>$readme,
        'filename'=>$filename,
        'text_cnt'=>$text_cnt,
        'items'=>array_map(function($i) use ($finfo, $path, $root) {
            $filename = $path.'/'.$i;
            $info = array();
            $info['name'] = $i;
            $info['mime'] = finfo_file($finfo, $filename);
            $info['size'] = filesize($filename);
            $info['path'] = str_replace($root, "", $filename);
            return $info;
        }, scandir($path))));
})->assert('path', '.+')->bind('browse');

$app->get('/config', function() use($app) {

    $dir = $app['document_root'].$app['assets_dir'].'/img/icons/16/';
    $list = scandir($dir);
    $list = array_filter($list, function($i) {
        return preg_match('/\.png$/', $i);
    });
    $list = array_map(function($i) {
        return basename($i);
    }, $list);
    $keys = array_map(function($i) {
        return str_replace(array(".png"), array(""), $i);
    }, $list);
    $list = array_map(function($i) use($app) {
        return $app['assets_dir'].'/img/icons/16/'.$i;
    }, $list);

    $mime = array_combine($keys, $list);

    return $app->json(array('browse_path' => $app['url_generator']->generate('browse', array('path'=>"__path__")),
        'mime'=>$mime));
});

return $app;