<?php
define('DB_USER', 'root');           // user MySQL
define('DB_PASSWORD', '');           // password MySQL
define('DB_HOST', 'localhost');      // host
define('DB_NAME', 'quanlydethitracnghiem'); // tên database đã tạo

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or die('Không kết nối được với MySQL: ' . mysqli_connect_error());

mysqli_set_charset($dbc, 'utf8mb4');
