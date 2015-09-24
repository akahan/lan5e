<?php

namespace App\Core;

// use Slim\App;
use PDO;

use App\Core;
use App\Core\Item;

class Catalog {

    private $_items = [];

    public function __construct() {
        $sth = Core::$dbh->prepare('
            SELECT
                c.`catalog_id`,
                c.`name`,
                c.`group_id`,
                cg.`name` group_name,
                c.`description`
            FROM
                `catalog` c
                INNER JOIN `catalog_groups` cg USING(`group_id`)
            WHERE
                c.`group_id` = ?
        ');
        $sth->execute(array(1));
        $this->_items['cca'] = $sth->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\\Core\\Item' );
        $sth->execute(array(2));
        $this->_items['cu'] = $sth->fetchAll( PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'App\\Core\\Item' );
    }

    public function items() {
        return $this->_items;
    }

    public static function get_item_prices($catalog_id) {
        $sth = Core::$dbh->prepare('
            SELECT
                p.`price_group_id`,
                pg.`name` `price_group_name`,
                pg.`min_total`,
                p.`price`
            FROM
                `prices` p
                INNER JOIN `price_groups` pg USING(`price_group_id`)
            WHERE
                p.`catalog_id` = ?
        ');

        $sth->execute( array($catalog_id) );
        return $sth->fetchAll( PDO::FETCH_ASSOC );
    }

    public static function get_item_price( $catalog_id, $total_sum ) {
        $sth = Core::$dbh->prepare('
            SELECT
                p.`price`
            FROM
                `prices` p
                INNER JOIN `price_groups` pg USING(`price_group_id`)
            WHERE
                p.`catalog_id` = ? AND ( pg.`min_total` IS NULL OR pg.`min_total` = ?)
            ORDER BY p.`price_group_id`
            LIMIT 1
        ');

        // var_dump( [ $catalog_id, $total_sum ] );
        $sth->execute( [ $catalog_id, $total_sum ] );
        $price = $sth->fetch( PDO::FETCH_OBJ )->price;
        // var_dump($price);
        return $price;
    }

    public static function get_title($catalog_id) {
        $sth = Core::$dbh->prepare('
            SELECT
                c.`name`,
                c.`description`
            FROM
                `catalog` c
            WHERE
                c.`catalog_id` = ?
            LIMIT 1
        ');

        $sth->execute( [ $catalog_id ] );
        $data = $sth->fetch( PDO::FETCH_ASSOC );
        // var_dump($data);
        return $data;
    }
}
