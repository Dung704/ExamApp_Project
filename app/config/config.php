<?php
define('DB_USER','root');
define('DB_PASSWORD','ab1XdbkD]DSX-6@T');
define('DB_HOST','localhost');
define('DB_NAME','qlbandochoi');

$dbc = @mysqli_connect(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME)
        OR die ('Không kết nối được với MySQL:' . mysqli_connect_error());

mysqli_set_charset($dbc,'utf8');

?>