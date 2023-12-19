<?php
    //create all database data
    $host = "localhost";
    $port = "5432";
    $dbname = "uas_lab";
    $user = "postgres";
    $password = '123lkokta';

    //create connection to database
    $connection = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    // if($connection){
    //     echo "berhasil";
    // }
?>