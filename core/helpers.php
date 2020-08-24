<?php

function correctNumberName(int $num, string $first, string $second, string $third) : string
{
    if ($num % 10 == 1 && ($num % 100 != 11)) {
        return $first;
    } else if (
                ($num % 10 >= 2 && $num % 10 < 5) &&
                !($num % 100 >= 12 && $num % 100 < 15)
            ) {
        return $second;
    } else {
        return $third;
    }
}

function loadedImageChecked(array $file) : array
{
    $errors = [];

    if ($file['error']) {
        $errors[] = 'Ошибка при загрузке изображения';
    }
    if ($file['name'] == '') {
       $errors[] = 'Некорректное имя файлa изображение';
    }
    if ($file['size'] > MAX_IMG_SIZE) {
       $errors[] = 'Файл изображения превышает допустимый размер';
    }
    if (!imageTypeChecked($file['tmp_name'])) {
       $errors[] = 'Файл изображения имеет недопустимый тип';
    }
    return $errors;
}

function imageTypeChecked(string $filename) : bool
{
    return in_array(mime_content_type($filename), ALLOWED_IMG_TYPES);
}
