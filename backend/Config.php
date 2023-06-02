<?php
    define('DB_HOST','');//URL or Address of databse host
    define('DB_USER','');//Username if any
    define('DB_PASSWORD','');//Password of database
    define('DB_NAME','');//Name of the database (Probably GrogBase)

    $connection = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    if($connection->connect_error)
    {
        die('connection_failed: ' . $connection->connect_error);
    }
?>