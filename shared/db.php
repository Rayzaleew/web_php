<?php

$dbhost = "localhost";
$dbport = "5432";
$dbname = "user105";
$dbpass = "pg_password";
$dbuser = "user105";

$connstr = "host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpass";

$dbconn = pg_connect($connstr);


?>