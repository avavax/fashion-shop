<?php

return [
    [
        'pattern' => '/^\/catalog\/([0-9aA-zZ_-]+)\/(\d*)$/',
        'controller' => 'catalog/index',
        'params' => ['category', 'page'],
    ],
    [
        'pattern' => '/^\/$/',
        'controller' => 'catalog/index',
    ],
    [
        'pattern' => '/^\/delivery\/$/',
        'controller' => 'delivery',
    ],
    [
        'pattern' => '/^\/admin\/products\/(add)\/$/',
        'controller' => 'products/index',
        'params' => ['action'],
    ],
    [
        'pattern' => '/^\/admin\/products\/(\d+)$/',
        'controller' => 'products/index',
        'params' => ['id'],
    ],
    [
        'pattern' => '/^\/ajax\/products\/add\/$/',
        'controller' => 'products/add',
    ],
    [
        'pattern' => '/^\/ajax\/products\/delete\/$/',
        'controller' => 'products/delete',
    ],
    [
        'pattern' => '/^\/admin\/products\/$/',
        'controller' => 'products/index',
    ],
    [
        'pattern' => '/^\/admin\/?$/',
        'controller' => 'orders/index',
    ],
    [
        'pattern' => '/^\/ajax\/order\/$/',
        'controller' => 'orders/order',
    ],
];
