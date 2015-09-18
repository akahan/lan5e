<?php

namespace App\Core;

use App\Core;
use App\Core\Catalog;

class Shopcart {

    private $_items = [];

    public function __construct() {
        $this->_init_from_session(Core::$session->shopcart);
    }

    public function items() {
        return $this->_items;
    }

    public function size() {
        return count($this->_items);
    }

    private function _init_from_session($raw_cart) {
        // Core::dump( $raw_cart );
        if ( $raw_cart && is_array($raw_cart) ) {
            foreach ( $raw_cart as $catalog_id => $data ) {
                $this->_items[$catalog_id] = [
                    'amount' => (int) $data['amount'],
                    'price'  => 2321.33
                    // 'price'  => Catalog::get_item_price( $catalog_id, $amount )
                ];
            }
        }
    }

    public function add( $catalog_id, $amount ) {
        if ( is_array($this->_items[$catalog_id]) ) {
            $this->_items[$catalog_id]['amount'] += $amount;
        }
        else {
            $this->_items[$catalog_id] = [
                'amount' => (int) $amount,
                'price'  => null
                // 'price'  => Catalog::get_item_price( $catalog_id, $amount )
            ];
        }

        $this->_update_session();
    }

    public function delete( $catalog_id ) {
        if ( is_array($this->_items[$catalog_id]) ) {
            unset($this->_items[$catalog_id]);
            $this->_update_session();
        }
    }

    public function to_session() {
        $raw_cart = [];

        foreach ( $this->_items as $catalog_id => $data ) {
            $raw_cart[$catalog_id] = [
                'amount' => $data['amount']
            ];
        }

        // Core::dump( $raw_cart );
        return $raw_cart;
    }

    private function _update_session() {
        Core::$session->shopcart = $this->to_session();
    }

}
