<?php
$loader = require 'vendor/autoload.php';
$loader->register();

$dotenv = new Dotenv\Dotenv(__DIR__);
$dotenv->overload();
$dotenv->required('MANDRILL_API_KEY');

return $loader;
