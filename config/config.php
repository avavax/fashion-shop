<?php

define('DB_NAME', 'fashion_shop');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');

define('MAX_IMG_SIZE', 3 * 1025 * 1024);
define('ALLOWED_IMG_TYPES', ['image/jpeg', 'image/png', 'image/pjpg']);
define('IMGS_STORAGE', '/public/img/products/');

define('PRODUCTS_ON_PAGE', 9);
define('FREE_DELIVERY', 2000);
define('DELIVERY_PRICE', 280);
define('DELIVERY_PRICE_INTRADAY', 500);
