<?php
// Routes

$app->get('/', 'App\FO\Controllers\Root:index')->setName('main');
$app->get('/item/{catalog_id}', 'App\FO\Controllers\Root:item')->setName('item');
$app->get('/delivery', 'App\FO\Controllers\Root:delivery')->setName('delivery');
$app->get('/about', 'App\FO\Controllers\Root:about')->setName('about');

$app->get('/cart', 'App\FO\Controllers\Cart:index')->setName('cart');
$app->post('/cart/add', 'App\FO\Controllers\Cart:add')->setName('cart_add');
$app->post('/cart/delete', 'App\FO\Controllers\Cart:delete')->setName('cart_del');
$app->post('/cart/clear', 'App\FO\Controllers\Cart:clear')->setName('cart_clr');
$app->post('/cart/checkout', 'App\FO\Controllers\Cart:checkout')->setName('cart_chk');
