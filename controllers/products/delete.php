<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/auth.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/products.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/orders.php';

$response = [
    'result' => false,
    'error' => '',
];

if ($userRole != 'admin') {
    echo json_encode($response);
    exit();
}

if (isset($_GET['id'])) {

    if (checkProductInOrders((int) $_GET['id'])) {
        $response['error'] = 'Товар присуствует в заказах';
    } else {
        $response['error'] .= !removeProduct((int) $_GET['id']) ? 'Не удалось удалить товар' : '';
    }
}

$response['result'] = empty($response['error']);

echo json_encode($response);
