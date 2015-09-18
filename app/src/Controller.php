<?php

namespace App;

use Slim\App;
use Slim\Container;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use App\Core as Core;

class Controller {
    protected $router;
    protected $view;

    public function __construct( Container $c ) {
        $this->router = $c->get('router');
        $this->view = $c->get('view');
    }

    public static function on_request( $request, $response, $args ) {

        return $response;
    }
}
