<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/models/categories.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/products.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/orders.php';

$categories = getAllCategories();
$currentCategorySlug = empty(URL_PARAMS['category']) ? 'all' : URL_PARAMS['category'];

$request = [
    'category' => $currentCategorySlug,
    'page' => !empty(URL_PARAMS['page']) ? (int) URL_PARAMS['page'] : 1,
];

if (!empty($_GET)) {

    $request['filters'] = prepareFiltersVariable($_GET);
}

$products = getFilteredProducts($request);

/** Обработка случая вызова страницы новых товаров или sale без выбора фильтров по цене */
if (isset($request['filters']['minPrice']) && $request['filters']['minPrice'] == 0) {
    $request['filters']['minPrice'] = $products['minPrice'];
}
if (isset($request['filters']['maxPrice']) && $request['filters']['maxPrice'] == PHP_INT_MAX) {
    $request['filters']['maxPrice'] = $products['maxPrice'];
}

$topmenu = render('parts/v_topmenu');
$filters = render('parts/v_filters', [
    'request' => $request,
    'products' => $products,
    'categories' => $categories,
    'currentCategorySlug' => $currentCategorySlug,
]);
$pagination = render('parts/v_pagination', [
    'products' => $products,
    'getParamsForPagination' => isset($currentGET) ? "?{$currentGET}" : '',
]);
$pageContent = render('v_catalog', [
    'filters' => $filters,
    'pagination' => $pagination,
    'products' => $products,
    'request' => $request,
]);

echo render('v_layout', [
    'title' => 'Fashion',
    'topmenu' => $topmenu,
    'pageContent' => $pageContent,
]);
