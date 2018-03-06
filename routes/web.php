<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// just to populate table with some data
$router->get('recipient/generatedata', 'RecipientController@createRecipient');
$router->get('offers/generatedata', 'SpecialOfferController@createOffers');
$router->get('voucher/generatedata', 'VoucherController@createVoucherData');



$router->get('recipient', 'RecipientController@listAll');
$router->post('recipient', 'RecipientController@create');

$router->get('offers', 'SpecialOfferController@listAll');
$router->post('offers', 'SpecialOfferController@create');

$router->get('voucher', 'VoucherController@listAll');
$router->get('voucher/valid', 'VoucherController@listValid');
$router->get('voucher/used', 'VoucherController@listUsed');
$router->get('voucher/expired', 'VoucherController@listExpired');
//$router->get('voucher/{email}/list', 'VoucherController@listByEmail');
$router->get('voucher/{code}', 'VoucherController@get');
$router->post('voucher', 'VoucherController@create');
$router->post('voucher/validate', 'VoucherController@validateVoucher');

