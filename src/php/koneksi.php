<?php
    //create all database data
    $host = "localhost";
    $port = "5432";
    $dbname = "uas_lab";
    $user = "postgres";
    $password = '543210';

    //create connection to database
    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    // if($connection){
    //     echo "berhasil";
    // }
?>