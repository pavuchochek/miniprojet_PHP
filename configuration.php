<?php 
use Dotenv\Dotenv;
require __DIR__."/vendor/autoload.php";
$dotenv = Dotenv::createImmutable(__DIR__,"/.env");
$dotenv->safeLoad();

$db_name = $_ENV['DATABASE_NAME'];
$user=$_ENV['USER'];
$password=$_ENV['PASSWORD'];
$db_address=$_ENV['DATABASE_ADDRESS'];
?>