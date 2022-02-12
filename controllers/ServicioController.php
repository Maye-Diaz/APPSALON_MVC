<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController {
    public static function index(Router $router) {
        session_start(); // Iniciar session

        isAdmin(); // Revisa las sessiones iniciadas protege las rutas

        $servicios = Servicio::all(); // Va a mostrar todos los servicios

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]); 
    }

    public static function crear(Router $router) {
        session_start(); // Iniciar session
        isAdmin(); // Revisa las sessiones iniciadas  protege las rutas
        $servicio = new Servicio; // Se crea la variable de servicio, se tiene ya una instancia $servicio
        $alertas = [];

       if($_SERVER['REQUEST_METHOD'] === 'POST') { // Pasar hacia la vista
            $servicio->sincronizar($_POST); // En el campo de formulario se mantiene lo que se escribe.

            $alertas = $servicio->validar();

            if(empty($alertas)) { // empty permite validar si un arreglo esta vacio o no
                $servicio->guardar(); // guarda en la base de datos
                header('Location: /servicios');
            }
      }

       $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
       ]);
    }

    public static function actualizar(Router $router) {
        session_start(); //para definir en caso de que haya errores
        isAdmin(); // Revisa las sessiones iniciadas protege las rutas

        if(!is_numeric($_GET['id'])) return;
        $servicio = Servicio::find($_GET['id']); // Trae el servicio que se va a editar 
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST); // Se realiza el cambio de servicio

            $alertas = $servicio->validar();

            if(empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
           ]);
    }

    public static function eliminar() { // No requiere router porque solamente va a leer el id que se va a eliminar y lo elimina
        session_start();
        isAdmin(); // Revisa las sessiones iniciadas protege las rutas
       
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            header('Location: /servicios');
            
        }
    }
}