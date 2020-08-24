<?php

function getUserById(string $id) : ?array
{
    $sql = 'SELECT user_id, email, status, password FROM users WHERE user_id = :user_id';
    $query = dbQuery($sql, ['user_id' => $id]);
    $user = $query->fetch();
    return $user === false ? null : $user;
}

function getUserByEmail(string $email) : ?array
{
    $sql = 'SELECT user_id, password, status FROM users WHERE email = :email';
    $query = dbQuery($sql, ['email' => $email]);
    $user = $query->fetch();
    return $user === false ? null : $user;
}
