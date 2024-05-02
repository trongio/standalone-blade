<?php
require_once '../vendor/autoload.php';

use Illuminate\Events\Dispatcher;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;

// Create an instance of BladeCompiler
$filesystem = new Filesystem();
$compiler = new BladeCompiler($filesystem, __DIR__ . '/../cache');

// Create an instance of EngineResolver and bind BladeCompiler to it
$resolver = new EngineResolver();
$resolver->register('blade', function () use ($compiler) {
	return new CompilerEngine($compiler);
});

// Create an instance of FileViewFinder
$viewFinder = new FileViewFinder($filesystem, [__DIR__ . '/../templates']);

// Create an instance of Factory and pass EngineResolver and FileViewFinder to it
$view = new Factory($resolver, $viewFinder, new Dispatcher());

// Get the requested URI
$uri = $_SERVER['REQUEST_URI'];

// Extract the route name from the URI (assuming the URI has a simple structure)
$routeName = trim($uri, '/');
$routeName = explode('?', $routeName)[0];
// If the route name is empty, default it to 'home'
$routeName = $routeName ?: 'home';


// Render the corresponding blade template
echo $view->make('pages.'.$routeName)->render();
