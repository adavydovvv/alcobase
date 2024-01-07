<?php
session_start();

if (!isset($_SESSION["login"])) {
    echo "Необходимо авторизоваться.";
    exit;
}
?>