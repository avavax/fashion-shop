<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/auth.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/orders.php';

$currentPage = '';

if ($userRole == 'admin' || $userRole == 'operator') {

    $title = 'Заказы';
    $currentPage = 'orders';
    $orders = getAllOrders();
    $pageContent = render('v_orders', ['orders' => $orders]);
    $topmenu = render('parts/v_admin_topmenu', [
        'currentPage' => $currentPage,
        'userRole' => $userRole,
    ]);

} else {

    $title = 'Авторизация';
    $pageContent = render('v_authorization', [
        'email' => $email ?? '',
        'password' => $password ?? '',
        'authError' => $authError ?? null
    ]);
    $topmenu = render('parts/v_topmenu');
}

echo render('v_layout', [
    'title' => $title,
    'topmenu' => $topmenu,
    'pageContent' => $pageContent,
]);
