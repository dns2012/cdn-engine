<?php 

require './vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

if (Config\Auth::authenticated($_SERVER)) {
    Config\Router::run();
}

