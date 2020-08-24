<?php

function getAllCategories() : array
{
    $sql = 'SELECT * FROM categories';
    $query = dbQuery($sql);
    return $query->fetchAll() ?? [];
}