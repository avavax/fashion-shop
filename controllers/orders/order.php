<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/orders.php';

$response = [
    'result' => false,
    'errors' => [],
    'status' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $response['errors'] = orderValidate($_POST);

    if (empty($response['errors'])) {
        $response['result'] = addOrder(prepareOrderVariable($_POST));
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['change_status'])) {
    $newStatus = changeOrderStatus(($_GET['id']));
    $response['result'] = $newStatus['result'];
    $response['status'] = $newStatus['newStatus'];
}

echo json_encode($response);
