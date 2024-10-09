<?php
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'skincare_db';

$db_connect = mysqli_connect($host, $username, $password, $dbname);

if (!$db_connect) {
    die("gagal terhubung ke database $dbname :" .mysqli_connect_error());
}
?>