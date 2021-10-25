<?php 

/* define database credentials 

define ('DB_SERVER', 'localhost:3306');
define ('DB_USERNAME', 'lucmapsc_burns_c');
define ('DB_PASSWORD', 'Blackbridge01');
define ('DB_NAME', 'lucmapsc_data_explorer');
*/ 


define ('DB_SERVER', 'localhost:3306');
define ('DB_USERNAME', 'root');
define ('DB_PASSWORD', '');
define ('DB_NAME', 'lucmapsc_data_explorer');


$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if ($link === false){
    die("ERROR: Could not connect to database".mysqli_connect_error());
    echo "non connected";
}


?>