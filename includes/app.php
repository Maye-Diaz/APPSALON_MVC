<?php 
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // __DIR__ Es la dirección o ruta actual
$dotenv->safeLoad(); // Lo que va hacer safeLoad si esa archivo no existe no nos va a marcar un error

require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);