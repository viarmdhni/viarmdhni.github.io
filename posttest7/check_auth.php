<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    $_SESSION['redirect_after_login'] = $_GET['redirect'];
    header("Location: login.php");
    exit;
} else {
    header("Location: " . $_GET['redirect']);
    exit;
}
?>