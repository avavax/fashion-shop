<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/core/auth.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/core/helpers.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/products.php';

$response = [
    'result' => false,
    'errors' => [],
];

if ($userRole != 'admin') {
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {

    if (empty($_FILES['product-photo']['name']) && $_POST['id'] == '') {
       $response['errors'][] = 'Не добавлено изображение товара';
    }

    $response['errors'] = array_merge($response['errors'], productValidate($_POST));

    if (!empty($_FILES['product-photo']['name'])) {
        $response['errors'] = array_merge(
          $response['errors'],
          loadedImageChecked($_FILES['product-photo'])
        );
    }

    if (empty($response['errors'])) {

        if (!empty($_FILES['product-photo']['name'])) {
          $path = $_SERVER['DOCUMENT_ROOT'] . IMGS_STORAGE;
          if (!move_uploaded_file(
              $_FILES['product-photo']['tmp_name'],
              $path . $_FILES['product-photo']['name']
          )) {
              $response['errors'][] = 'Ошибка загрузки изображения';
          }
        }

        if ($_POST['id'] == '') {
            if (!addProduct($_POST, $_FILES['product-photo'])) {
                $response['errors'][] = 'Не удалось добавить товар';
            }
        } else {
            if (!changeProduct($_POST, $_FILES['product-photo'])) {
                $response['errors'][] = 'Не удалось обновить данные о товаре';
            }
        }
    }

    $response['result'] = empty($response['errors']);
}

echo json_encode($response);
