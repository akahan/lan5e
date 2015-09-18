<?php

namespace App;

use \RKA\Session;
use App\Core\Shopcart;

class Core {
    private static $_instance = null;

    public static $app = null;
    public static $dbh = null;
    public static $session = null;
    public static $logger = null;

    // public static $stash = [];
    public static $shopcart = [];

    private function __construct() {}
    private function __clone() {}

    public static function instance() {
        if ( is_null(self::$_instance) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public static function sdump($var) {
        ob_start();
        // echo '<pre>';
        var_dump($var);
        // echo '</pre>';
        $a = ob_get_contents();
        ob_end_clean();
        // $a = htmlspecialchars( $a, ENT_QUOTES );
        return $a;
    }

    public static function dump($var) {
        echo '<pre>';
        ob_start();
        var_dump($var);
        $a = ob_get_contents();
        ob_end_clean();
        echo htmlspecialchars( $a, ENT_QUOTES );
        echo '</pre>';
    }
}

