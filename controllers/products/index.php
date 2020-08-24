<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/auth.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/products.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/categories.php';

$currentPage = '';

if ($userRole == 'admin') {

    $title = 'Товары';
    $currentPage = 'products';

    if (isset(URL_PARAMS['action']) && URL_PARAMS['action'] == 'add') {

        $categories = getAllCategories();
        $pageContent = render('v_add_product', [
            'product' => $product ?? null,
            'categories' => $categories,
        ]);

    } elseif (isset(URL_PARAMS['id']) && is_numeric(URL_PARAMS['id'])) {

        $product = getOneProduct((int) URL_PARAMS['id']);
        $categories = getAllCategories();
        $pageContent = render('v_add_product', [
            'product' => $product ?? null,
            'categories' => $categories,
        ]);

    } else {
        $products = getALLProducts();
        $pageContent = render('v_products', ['products' => $products]);
    }

    $topmenu = render('parts/v_admin_topmenu', [
        'currentPage' => $currentPage,
        'userRole' => $userRole,
    ]);

} else {

    $title = 'Авторизация';
    $topmenu = render('parts/v_topmenu');
    $pageContent = render('v_authorization', [
        'email' => $email ?? '',
        'password' => $password ?? '',
        'authError' => $authError ?? null
    ]);
}

echo render('v_layout', [
    'title' => $title,
    'topmenu' => $topmenu,
    'pageContent' => $pageContent,
]);
