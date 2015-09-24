<?php

namespace App\FO\Controllers;


use App\Core;
use App\Core\Shopcart;

use App\Controller as Controller;

final class Cart extends Controller {

    public function index($request, $response, $args) {
        // $stash = Core::$stash;

        // $stash['page'] = 'cart';
        $this->view['page'] = 'cart';
        // Core::dump($stash);

        $this->view->render( $response, 'cart/index.html.twig' );

        return $response;
    }

    public function add($request, $response, $args) {
        // $stash = Core::$stash;
        // Core::$logger->info("Home page action dispatched");
        $p = $request->getParsedBody();

        Core::$shopcart->add( $p['catalog_id'], $p['amount'] );
        // Core::dump(Core::$shopcart);

        $answer = [ 'success' => true ];

        $top_view_html = $this->view->fetch( 'cart/top_view.html.twig' );
        // Core::dump($top_view_html);
        $answer['top_view'] = $top_view_html;

        $response->withHeader('Content-type', 'application/json');
        echo json_encode($answer);

        return $response;
    }

    public function delete($request, $response, $args) {
        $p = $request->getParsedBody();

        Core::$shopcart->delete( $p['catalog_id'] );

        $answer = [ 'success' => true ];

        if (Core::$shopcart->size() > 0) {
            $top_view_html = $this->view->fetch( 'cart/top_view.html.twig' );
            $answer['top_view'] = $top_view_html;
        }
        else {
            $answer['empty'] = true;
        }

        $response->withHeader('Content-type', 'application/json');
        echo json_encode($answer);

        return $response;
    }

    public function clear($request, $response, $args) {

        Core::$shopcart->clear();

        $answer = [ 'success' => true ];

        $response->withHeader('Content-type', 'application/json');
        echo json_encode($answer);

        return $response;
    }

    public function checkout($request, $response, $args) {

        Core::$shopcart->clear();

        $answer = [ 'success' => true ];

        $response->withHeader('Content-type', 'application/json');
        echo json_encode($answer);

        return $response;
    }

}
