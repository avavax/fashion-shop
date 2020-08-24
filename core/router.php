<?php

$routes = include_once $_SERVER['DOCUMENT_ROOT'] . '/config/routes.php';

$currentUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$currentGET = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

$routeParams = [
    'controller' => '404',
    'params' => [],
];

foreach ($routes as $route) {
    $matches = [];

    if (preg_match($route['pattern'], $currentUri, $matches)) {
        $routeParams['controller'] = $route['controller'];
        if (isset($route['params'])) {
            for ($i = 0; $i < count($route['params']); $i++) {
                $routeParams['params'][$route['params'][$i]] = $matches[$i + 1];
            }
        }
        break;
    }
}

define('URL_PARAMS', $routeParams['params']);

if ($routeParams['controller'] !== '404') {
    include_once $_SERVER['DOCUMENT_ROOT'] . "/controllers/{$routeParams['controller']}.php";
} else {
    header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
    echo render('v_layout', [
        'title' => 'Страница 404',
        'pageContent' => render('v_404'),
        'topmenu' => render('parts/v_topmenu'),
    ]);
}
