<?php

function prepareFiltersVariable(array $filters) : array
{
    return [
        'sale' => isset($filters['sale']),
        'new' => isset($filters['new']),
        'sort' => isset($filters['sort']) && $filters['sort'] == 'price' ? 'price' : 'title',
        'order' => isset($filters['order']) && $filters['order'] == 'desc' ? SORT_DESC : SORT_ASC,
        'minPrice' => isset($filters['min_price']) ? (int) $filters['min_price'] : 0,
        'maxPrice' => isset($filters['max_price']) ? (int) $filters['max_price'] : PHP_INT_MAX,
    ];
}

function getALLProducts() : array
{
    $result = [];
    $sql = 'SELECT categories.title AS category, products.product_id, products.price, products.new, products.title AS name
        FROM products
        LEFT JOIN product_category ON products.product_id = product_category.product_id
        LEFT JOIN categories ON categories.category_id = product_category.category_id
        ORDER BY products.product_id DESC';
    $query = dbQuery($sql);
    $products = $query->fetchAll() ?? [];

    foreach ($products as $product) {
        if (isset($result[$product['product_id']])) {
            $result[$product['product_id']]['category'] .= " <br>{$product['category']}";
        } else {
            $result[$product['product_id']] = [
                'name' => $product['name'],
                'price' => $product['price'],
                'new' => $product['new'],
                'category' =>
                    $product['category']
            ];
        }
    }
    return $result;
}

function getOneProduct(int $id) : array
{
    $result = [];
    $sql = 'SELECT *, products.title AS name, categories.title AS category FROM products
        LEFT JOIN product_category ON products.product_id = product_category.product_id
        LEFT JOIN categories ON categories.category_id = product_category.category_id
        WHERE products.product_id = :product_id';
    $query = dbQuery($sql, ['product_id' => $id]);
    $product = $query->fetchAll() ?? [];

    foreach ($product as $item) {
        if (isset($result['category'])) {
            $result['category'][] = $item['category'];
        } else {
            $result = [
                'id' => $item['product_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'new' => $item['new'],
                'sale' => $item['sale'],
                'img' => $item['image'],
                'category' => [
                    $item['category']
                ],
            ];
        }
    }
    return $result;
}

function getFilteredProducts($request = []) : array
{
    $result = [
        'count' => 0,
        'currentPage' => $request['page'],
        'category' => $request['category'],
        'minPrice' => 0,
        'maxPrice' => 0,
        'items' => [],
    ];

    $params = [];
    $sql = 'SELECT *, products.title AS title FROM products';

    if ($request['category'] !== 'all') {
        $sql .= ' LEFT JOIN product_category ON products.product_id = product_category.product_id
            LEFT JOIN categories ON categories.category_id = product_category.category_id
            WHERE categories.slug = :slug';
        $params['slug'] = $request['category'];
    } else {
        $sql .= ' WHERE true';
    }

    $sql .= isset($request['filters']['new']) && $request['filters']['new'] ? " AND new = 1" : '';
    $sql .= isset($request['filters']['sale']) && $request['filters']['sale'] ? " AND sale = 1" : '';

    $result['maxPrice'] = getMaxPrice($sql, $params);
    $result['minPrice'] = getMinPrice($sql, $params);

    if (isset($request['filters']['minPrice']) && isset($request['filters']['maxPrice'])) {
        $sql .= ' AND (price >= :minPrice AND price <= :maxPrice)';
        $params['minPrice'] = $request['filters']['minPrice'];
        $params['maxPrice'] = $request['filters']['maxPrice'];
    }

    $result['count'] = getProductsCount($sql, $params);
    if ($result['count'] == 0) {
        return $result;
    }

    if (isset($request['filters']['sort'])) {
        $sql .= $request['filters']['sort'] == 'title' ? ' ORDER BY products.title' : ' ORDER BY price';
        $sql .= $request['filters']['order'] == SORT_ASC ? ' ASC' : ' DESC';
    }

    $firstLimit = ($request['page'] - 1) * PRODUCTS_ON_PAGE;
    $sql .= " LIMIT {$firstLimit}, " . PRODUCTS_ON_PAGE;

    $query = dbQuery($sql, $params);
    $result['items'] = $query->fetchAll() ?? [];

    return $result;
}

function getMaxPrice(string $sql, $params = []) : int
{
    $sql = str_replace(
        'SELECT *, products.title AS title',
        'SELECT MAX(price) AS max',
        $sql
    );
    $query = dbQuery($sql, $params);
    return $query->fetch()['max'] ?? 0;
}

function getMinPrice(string $sql, $params = []) : int
{
    $sql = str_replace(
        'SELECT *, products.title AS title',
        'SELECT MIN(price) AS min',
        $sql
    );
    $query = dbQuery($sql, $params);
    return $query->fetch()['min'] ?? 0;
}

function getProductsCount(string $sql, $params = []) : int
{
    $sql = str_replace(
        'SELECT *, products.title AS title',
        'SELECT COUNT(*) AS count',
        $sql
    );
    $query = dbQuery($sql, $params);
    return $query->fetch()['count'];
}

function productValidate(array $params) : array
{
    $errors = [];
    if (strip_tags(trim($params['product-name'])) == '') {
        $errors[] = 'Не заполнено поле название продукта';
    }
    if ($params['product-price'] == '') {
        $errors[] = 'Не указана цена продукта';
    }
    if (!is_numeric($params['product-price'])) {
        $errors[] = 'В поле цена нет цифрового значения';
    }
    if (!isset($params['category'])) {
        $errors[] = 'Не выбрана ни одна категория';
    }
    return $errors;
}

function addProduct(array $fields, array $imagefile = []) : bool
{
    $result = true;

    $sql = 'INSERT INTO products SET
        title = :title,
        price = :price,
        sale = :sale,
        new = :new,
        image = :image';

    $params = [
        'title' => strip_tags(trim($fields['product-name'])),
        'price' => (int) trim($fields['product-price']),
        'sale' => isset($fields['sale']) ? 1 : 0,
        'new' => isset($fields['new']) ? 1 : 0,
        'image' => $imagefile['name'],
    ];

    $result = (bool) dbQuery($sql, $params);
    $product_id = dbQuery('SELECT LAST_INSERT_ID()')->fetch()['LAST_INSERT_ID()'];
    addProductCategories($fields['category'], $product_id );

    return $result;
}

function changeProduct(array $fields, array $imagefile = []) : bool
{
    $result = true;
    $product_id = (int) $fields['id'];

    $sql = 'UPDATE products
        SET title = :title,
        price = :price,
        sale = :sale,
        new = :new,
        image = :image
        WHERE product_id = :product_id';

    $params = [
        'product_id' => $product_id,
        'title' => strip_tags(trim($fields['product-name'])),
        'price' => (int) trim($fields['product-price']),
        'sale' => isset($fields['sale']) ? 1 : 0,
        'new' => isset($fields['new']) ? 1 : 0,
        'image' => $imagefile['name'] == '' ? $fields['old-product-photo'] : $imagefile['name'],
    ];

    $result = (bool) dbQuery($sql, $params);

    removeProductCategorise($product_id);
    addProductCategories($fields['category'], $product_id);

    return $result;;
}

function addProductCategories(array $categories, int $product_id) : void
{
    $sql = 'INSERT INTO product_category (product_id, category_id )
        VALUES (:product_id, :category_id)';

    foreach ($categories as $cat) {
        dbQuery($sql, [
            'product_id' => $product_id,
            'category_id' => (int) $cat,
        ]);
    }
}

function removeProductCategorise(int $product_id) : bool
{
    $sql = 'DELETE FROM product_category WHERE product_id = :product_id';
    return (bool) dbQuery($sql, ['product_id' => $product_id]);
}

function removeProduct(int $product_id) : bool
{
    $sql = 'DELETE FROM products WHERE product_id = :product_id';
    return (bool) dbQuery($sql, ['product_id' => $product_id]);
}
