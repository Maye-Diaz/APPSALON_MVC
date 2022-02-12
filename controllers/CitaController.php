<?php

namespace Controllers; // Es lo que importa

use MVC\Router;

class CitaController {
    public static function index( Router $router ) {

        if(!isset($_SESSION)) 
        { 
        session_start(); // Va a arrancar la session de nuevo
        } 

        isAuth(); // Ejecuta la función del archivo funciones, comprueba si el usuario esta autenticado o no.

        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'] // De esta forma esta variable esta disponible en la vista indes.php
        ]);
    }
}

