<?php 

namespace Model; // modelo

class CitaServicio extends ActiveRecord { // extends quiere decir que hereda en este caso de ActiveRecord
    protected static $tabla = 'citasservicios';
    protected static $columnasDB = ['id', 'ServicioId', 'CitaId' ]; // Es una relación de muchos a muchos la llave foranea
    // uno a uno cada persona tiene un perfil, usuario...
    public $id;
    public $ServicioId;
    public $CitaId;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->CitaId = $args['CitaId'] ?? '';
        $this->ServicioId= $args['ServicioId'] ?? '';
        //var_dump("serviciosid",$this->ServicioId);
        
    }
       
}