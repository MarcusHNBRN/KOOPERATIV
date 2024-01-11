<?php
require 'vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$apiKey = getenv('API_KEY');
$islandName = getenv('ISLAND_NAME');
$hotelName = getenv('HOTEL_NAME');
$userName = getenv('USER_NAME');
$stars = getenv('STARS');
?>
