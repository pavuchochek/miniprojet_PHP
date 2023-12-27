<?php 
require "vendor/autoload.php";
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__,".env");
$dotenv->load();
$db_name = $_ENV['DATABASE_NAME'];
$user=$_ENV['USER'];
$password=$_ENV['PASSWORD'];
$db_address=$_ENV['DATABASE_ADDRESS'];
?>