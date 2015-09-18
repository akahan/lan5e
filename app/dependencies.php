<?php

use App\Core;
use App\Core\Catalog;

// Core::$app = $app;

// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');

    $view = new \Slim\Views\Twig( $settings['view']['template_path'], $settings['view']['twig'] );

    // Add extensions
    $view->addExtension( new Slim\Views\TwigExtension( $c->get('router'), $c->get('request')->getUri()) );
    $view->addExtension( new Twig_Extension_Debug() );

    $view->getEnvironment()->addFunction( new Twig_SimpleFunction( 'get_title', function ($catalog_id) {
        return Catalog::get_title($catalog_id);
    }));

    $view->getEnvironment()->addFilter( new Twig_SimpleFilter( 'plural', function ( $endings, $number ) {
        $cases = [2, 0, 1, 1, 1, 2];
        $n = $number;
        return sprintf( $endings[ ($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[ min( $n % 10, 5 ) ] ], $n );
    }));

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};

$container['dbh'] = function ($c) {
    $settings = $c->get('settings');

    $db_dsn = $settings['db']['dsn'];
    $db_user = $settings['db']['user'];
    $db_pass = $settings['db']['pass'];
    $dbh = new PDO( $db_dsn, $db_user, $db_pass, [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
    ] );
    $dbh->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

    return $dbh;
};

// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\FO\Controllers\Root'] = function ($c) {
    return new App\FO\Controllers\Root( $c );
};

$container['App\FO\Controllers\Cart'] = function ($c) {
    return new App\FO\Controllers\Cart( $c );
};

// $container['errorHandler'] = function ($c) use ($app) {
//   return function ($request, $response, $exception) use ( $c, $app ) {
//     $data = [
//       'code' => $exception->getCode(),
//       'message' => $exception->getMessage(),
//       'file' => $exception->getFile(),
//       'line' => $exception->getLine(),
//       'trace' => explode("\n", $exception->getTraceAsString()),
//     ];

//     // if ($app['mode'] === 'development') {
//         // Output exception message
//         echo $exception->getMessage();

//         // Output stacktrace
//         debug_print_backtrace();

//     // } else {
//     //     echo "Something went wrong. We are looking into it.";
//     //     // PRO TIP: Use a third-party logger here (e.g. Monolog)
//     // }

//     return $response;

//     // return $c->get('response')->withStatus(500)
//     //          ->withHeader('Content-Type', 'application/json')
//     //          ->write(json_encode($data));
//   };
// };
