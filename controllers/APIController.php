<?php

namespace Controllers; // El que esta asociado a esta carpeta

use Model\Cita;
use Model\Citaservicio;
use Model\Servicio; // Importación que es muy importante.

class APIController {
    public static function index() { // index es el primer método.
        $servicios = Servicio::all(); //all método extático no requiere instanciar
        echo json_encode($servicios); // función para convertir un objeto a json.
    }
    // Crear el nuevo métodos
    public static function guardar() {
        
        // Almacena la Cita y devuelve el ID
        $cita = new Cita($_POST); // Crea un objeto de cita
        $resultado = $cita->guardar(); // El método es guardar

        $id = $resultado['id'];

        // Almacena la Cita y el Servicio llave foranea de muchos a muchos

        // Almacena los Servicios con el ID de la cita
        $idServicios = explode(",", $_POST['servicios']); // explode toma el separador en este caso indico que se auna coma, el segundo parametro es el styring $_POST['servicios']
        //var_dump($idServicios);
        foreach($idServicios as $idServicio) { // de esta forma va a ir instanciando
            $args = [
                'CitaId' => $id, // => es un arreglo asociativo
                'ServicioId' => $idServicio
            ];
            //var_dump($args);
            $w=$citaServicio = new CitaServicio($args); // Nos crea una nueva instancia de servicio
            //var_dump("objetocitaservicio",$citaServicio);
            $p=$w->guardar(); // de esta forma lo va a ir insertando y foreach va iterando y guardando
        }
        //var_dump("p", $p);
        // Retornamos una respuesta
        $respuesta = [
            'resultado' =>  $p //  $resultado para que lo retorne
        ];
        echo json_encode(['resultadocitasservicios1' => $respuesta]); // Retorna el resultado
    }

    public static function eliminar() {
        //debuguear($_SERVER); // aqui aparece toda la información de esa cita que es batante
        if($_SERVER['REQUEST_METHOD'] === 'POST') { // Solamente se ejecuta cuando esta en método en Post
            $id = $_POST['id']; // se lee el id
            $cita = Cita::find($id); // Se encuentra el id
            $cita->eliminar(); // se elimina el id
            header('Location:' . $_SERVER['HTTP_REFERER']); // Reedirecciona de la pagina donde estabamos
        }
    }
    
   } 