<?php

namespace App\FO\Controllers;

use App\Core;
use App\Controller as Controller;
use App\Core\Catalog as Catalog;

final class Root extends Controller {

    public function index( $request, $response, $args ) {
        // $stash = Core::$stash;

        $this->view['page'] = 'main';
        $this->view['catalog'] = new Catalog();

        // Core::dump($stash);

        $this->view->render( $response, 'index.html.twig' );

        return $response;
    }

    public function item( $request, $response, $args ) {
        $catalog_id = $args['catalog_id'];

        $item = [];

        $this->view->render( $response, 'item.html.twig', [
            'page' => 'item',
            'item' => $item,
        ]);

        return $response;
    }

    public function delivery( $request, $response, $args ) {
        Core::$logger->info("Delivery");

        $this->view->render( $response, 'delivery.html.twig', [
            'page' => 'delivery'
        ]);

        return $response;
    }

    public function about( $request, $response, $args ) {
        Core::$logger->info("About");

        $this->view->render( $response, 'about.html.twig', [
            'page' => 'about'
        ]);

        return $response;
    }
}
