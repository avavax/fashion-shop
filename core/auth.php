<?php

session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/sessions.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/models/users.php';

$userRole = '';
$token = $_SESSION['token'] ?? $_COOKIE['token'] ?? null;

if ($token !== null) {
    $session = getSessionByToken($token);

    if ($session !== null) {
        $user = getUserById($session['user_id']);
        $userRole = $user['status'];
    }
}

if (isset($_GET['logout']) && $_GET['logout'] == 'yes') {
    unset($_SESSION['token']);
    setcookie('token', '', time() - 1, '/');
    header('location: /admin/');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['auth'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $authError = true;

    if ($email != '' && $password != '') {
        $user = getUserByEmail($email);

        if ($user !== null && password_verify($password, $user['password'])) {

            $token = substr(bin2hex(random_bytes(128)), 0, 128);
            addSession($user['user_id'], $token);
            $_SESSION['token'] = $token;
            setcookie('token', $token, time() + 3600 * 24 * 30, '/');

            $userRole = $user['status'];
            $authError = false;
        }
    }
}
