<?php 

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController {
    public static function index( Router $router) { // Router es el objeto de $router
        session_start(); // Para que no aparezca undefined la $_session nombre 

        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d'); // Primero busca si ha un get, si no entonces va a mirar la fecha del servidor.
        $fechas = explode('-', $fecha); // Aqui modifica las fechas
        
        if( !checkdate($fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404'); //Si ponen una validación de día más del mes lleva a una página no encontrada.
        };

        
        //debuguear($fecha);

        // Consultar la base de datos
        $consulta = "SELECT citas.id, citas.hora, CONCAT( usuarios.nombre, ' ', usuarios.apellido) as cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre as servicio, servicios.precio  ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios ";
        $consulta .= " ON citasservicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasservicios.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);
        

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    }
}