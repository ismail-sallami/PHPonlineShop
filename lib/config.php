<?php
//cart config file

//Database Information
//$db_host = "localhost"; //Host address (most likely localhost)
//$db_name = "backend"; //Name of Database
//$db_user = "root"; //Name of database user
//$db_pass = "spaces"; //Password for database user
$db_name = "losiberi_backend"; //Name of Database
$db_user = "root"; //Name of database user
$db_pass = "spaces"; //Password for database user
$db_table_prefix = "um_";

GLOBAL $errors;
GLOBAL $successes;

$errors = array();
$successes = array();
$currency = '€'; //Currency Character or code
$shipping_cost      = 1.50; //shipping cost
$taxes              = array( //List your Taxes percent here.
    'VAT' => 12,
    'Service Tax' => 5
);


/* Create a new mysqli object with database connection parameters */
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
GLOBAL $mysqli;

if(mysqli_connect_errno()) {
    echo "Connection Failed: " . mysqli_connect_errno();
    exit();
}

//Direct to install directory, if it exists
if(is_dir("install/"))
{
    header("Location: install/");
    die();

}



