<?php

require_once 'ExpedInWrapper.php';

function dumpjson($var)
{
    var_dump(json_encode($var, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT));
}

$params = json_decode(file_get_contents('test-data.json'), true);
$uid = 'UID';

$api = new \ExpedIn\ExpedInWrapper([
    'key' => $params['key'],
    'url' => $params['url'],
]);

// create one order
$new_order = [
    'id_order' => time(), // your order ID
    'reference' => 'MYREF'.time(), // your unique reference
    'customer' => 'John Doe',
    'shipping_address' => [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'phone' => '0123456789',
        'city' => '',
        'zip' => '',
        'province' => '',
        'country' => '',
        'addresse2' => '',
        'company' => '',
        'country_code' => '',
        'province_code' => '',
        'email' => '',
    ],
    'shipping' => 'DPD', // 'DPD', 'Exped-In'
    'products' => [
        [
            'sku' => '1234567890123',
            'quantity' => 1,
        ],
    ],
];
$result = $api->setOrder($new_order);

// get all orders
$orders = $api->getOrders();
echo sprintf('Get %s orders %s', $orders['length'], "\n");
if (isset($orders['data'][0])) {
    dumpjson($orders['data'][0]);
}

// get one order
$order = $api->getOrder($uid);

// create supplier orders
$new_ordersupplier = [
    'id_order' => time(), // your order ID
    'reference' => 'MYREF'.time(), // your unique reference
    'supplier_name' => 'fournisseur',
    'supplier_reference' => 'REF_FOUR',
    'products' => [
        [
            'sku' => '1234567890123',
            'reference' => 'REFPRODUCT',
            'name' => 'Produit alpha',
            'ean13' => '1234567890123',
            'quantity' => 1,
        ],
    ],
];
$result = $api->setOrdersupplier($new_ordersupplier);

// get all supplier orders
$ordersuppliers = $api->getOrderssupplier();
echo sprintf('Get %s supplier order %s', $ordersuppliers['length'], "\n");
if (isset($ordersuppliers['data'][0])) {
    dumpjson($ordersuppliers['data'][0]);
}
// get one supplier order
$ordersupplier = $api->getOrdersupplier($uid);

// get all products
$products = $api->getProducts();
echo sprintf('Get %s products %s', $products['length'], "\n");
if (isset($products['data'][0])) {
    dumpjson($products['data'][0]);

    // get one product
    $product = $api->getProduct($products['data'][0]['uid']);
    dumpjson($product);
}
