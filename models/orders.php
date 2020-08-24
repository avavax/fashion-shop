<?php

function prepareOrderVariable(array $order) : array
{
    $result = array_map(function($item) {
        return strip_tags(trim($item));
    }, $order);
    $result['fullname'] = "{$result['name']} {$result['surname']} {$result['thirdName']}";
    if ($result['delivery'] == 'dev-yes') {
        $result['address'] = "г.{$result['city']} ул.{$result['street']} {$result['home']}-{$result['aprt']}";
    }
    return $result;
}

function orderValidate(array $order) : array
{
    $errors = [];

    if (empty($order['surname'])) {
        $errors['surname'] = 'Введите фамилию';
    }

    if (empty($order['name'])) {
        $errors['name'] = 'Введите имя';
    }

    if (empty($order['phone'])) {
        $errors['phone'] = 'Введите телефон';
    }

    if (empty($order['email'])) {
        $errors['email'] = 'Введите email';
    }

    if ($order['delivery'] == 'dev-yes') {

        if (empty($order['city'])) {
            $errors['city'] = 'Введите город';
        }

        if (empty($order['street'])) {
            $errors['street'] = 'Введите улицу';
        }

        if (empty($order['home'])) {
            $errors['home'] = 'Укажите дом';
        }

        if (empty($order['aprt'])) {
            $errors['aprt'] = 'Укажите номер квартиры';
        }
    }

    return $errors;
}

function addOrder(array $order) : bool
{

    $sql = 'INSERT INTO orders
        SET product = :product,
        fullname = :fullname,
        delivery = :delivery,
        pay = :pay,
        phone = :phone,
        email = :email';

    $params = [
        'product' => $order['product_id'],
        'fullname' => $order['fullname'],
        'delivery' => $order['delivery'],
        'pay' => $order['pay'],
        'phone' => $order['phone'],
        'email' => $order['email'],
    ];

    if (!empty($order['comment'])) {
        $params['comment'] = $order['comment'];
        $sql .= ', comment = :comment';
    }


    if (isset($order['address'])) {
        $params['address'] = $order['address'];
        $sql .= ', address = :address';
    }

    return (bool) dbQuery($sql, $params);
}

function getAllOrders() : array
{
    $result = [];
    $sql = 'SELECT * FROM orders
        LEFT JOIN products ON orders.product = products.product_id ORDER BY status, order_id DESC';

    $query = dbQuery($sql);
    $result = $query->fetchAll() ?? [];
    $result = array_map(function($order) {
        $order['fullPrice'] = $order['price'] + deliveryCost($order['price'], $order['delivery']);
        return $order;
    }, $result);
    return $result;
}

function changeOrderStatus(int $id) : array
{
    $sql = 'SELECT status FROM orders WHERE order_id = :order_id';
    $query= dbQuery($sql, ['order_id' => $id]);
    $currentStatus = $query->fetch()['status'];

    $newStatus = 1 - $currentStatus;
    $sql = 'UPDATE orders SET status = :status WHERE order_id = :order_id';

    dbQuery($sql, ['order_id' => $id, 'status' => $newStatus]);
    return [
        'result' => true,
        'newStatus' => $newStatus
    ];
}

function deliveryCost(int $pay, string $delivery) : int
{
    return $pay > FREE_DELIVERY || $delivery == 'dev-no' ? 0 : DELIVERY_PRICE;
}

function dliveryDate() : string
{
    $mon = [1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

    $deliveryTimeFrom = time() + 2 * 24 * 3600;
    $deliveryTimeTo = $deliveryTimeFrom + 2 * 24 * 3600;
    $firstDay = date('j', $deliveryTimeFrom);
    $secondDay = date('j', $deliveryTimeTo);
    $firstMonth = $mon[(int) date('n', $deliveryTimeFrom)];
    $secondMonth = $mon[(int) date('n', $deliveryTimeTo)];

    return $firstMonth == $secondMonth
        ? "{$firstDay}-{$secondDay} {$firstMonth}" :
        "{$firstDay} {$firstMonth} - {$secondDay} {$secondMonth}";
}

function checkProductInOrders(int $product_id) : bool
{
    $sql = 'SELECT COUNT(*) AS count FROM orders
        WHERE product = :product';
    $query = dbQuery($sql, ['product' => $product_id]);
    return $query->fetch()['count'] != 0;
}
