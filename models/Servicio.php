<?php

namespace Model;

class Servicio extends ActiveRecord { // herencia de ActiveRecord
    // Base de datos
    protected static $tabla = 'servicios'; // servicios es la tabla que contiene la información 
    protected static $columnasDB = ['id', 'nombre', 'precio']; // Crea un objeto igual al de la Base de Datos.

    public $id;// Registrar los atributos instanciar
    public $nombre;
    public $precio;

    public function __construct($args = []) // El constructor
    {   // toma forma de la instancia
        $this->id = $args['id'] ?? null; // $args['id'] es un arreglo asociativo
        $this->nombre = $args['nombre'] ?? '';
        $this->precio = $args['precio'] ?? '';
    }

    public function validar() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Servicio es Obligatorio';
        }
        if(!$this->precio) {
            self::$alertas['error'][] = 'El Precio del Servicio es Obligatorio';
        }
        if(!is_numeric($this->precio)) {
            self::$alertas['error'][] = 'El precio no es válido';
        }

        return self::$alertas;
    }
}    
