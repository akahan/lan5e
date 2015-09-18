<?php

use App\Core;
use App\Core\Shopcart;

// Application middleware

$app->add( function ( $request, $response, $next ) use ($app) {
    $core = Core::instance();

    Core::$app = $app;
    Core::$session = new \RKA\Session();

    $container = $app->getContainer();
    Core::$logger = $container['logger'];
    Core::$dbh = $container['dbh'];

    Core::$shopcart = new Shopcart();
    // throw new \Exception( Core::sdump($shopcart) );

    $container['view']['shopcart'] = Core::$shopcart;
    // Core::$stash = [ 'shopcart' => Core::$shopcart ];
    // Core::dump()
    return $next( $request, $response );
});

$app->add( new \RKA\SessionMiddleware( [ 'name' => 'SID' ] ) );
// $app->add( new \Slim\Csrf\Guard );
