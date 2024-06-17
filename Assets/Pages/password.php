<?php

function hashPassword($password) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    return $hashedPassword;
}

function verifyPassword($password, $hash) {
    $result = password_verify($password, $hash);
    return $result;
}