<?php

function addSession(int $userId, string $token) : bool
{
    $params = ['user_id' => $userId, 'token' => $token];
    $sql = 'INSERT sessions (user_id, token) VALUES (:user_id, :token)';
    dbQuery($sql, $params);
    return true;
}

function getSessionByToken(string $token) : ?array
{
    $sql = 'SELECT * FROM sessions WHERE token = :token';
    $query = dbQuery($sql, ['token' => $token]);
    $session = $query->fetch();
    return $session === false ? null : $session;
}
