<?php



class Element implements iToJson
{
    public $nombre;
    public $descripcion;
    public $numero_de_serie;
    public $estado;
    public $prioridad;

    public function __construct($nombre, $descripcion, $numero_de_serie, $estado, $prioridad)
    {
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->numero_de_serie = $numero_de_serie;
        $this->estado = $estado;
        $this->prioridad = $prioridad;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }

    public function getNumeroDeSerie()
    {
        return $this->numero_de_serie;
    }

    public function setNumeroDeSerie($numero_de_serie)
    {
        $this->numero_de_serie = $numero_de_serie;
    }

    public function getEstado()
    {
        return $this->estado;
    }


    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function getPrioridad()
    {
        return $this->prioridad;
    }

    public function setPrioridad($prioridad)
    {
        $this->prioridad = $prioridad;
    }


    public function toJson()
    {
        return '{' .
        '"nombre": "' . $this->nombre . '", ' .
        '"descripcion": "' . $this->descripcion . '", ' .
        '"numero_de_serie": "' . $this->numero_de_serie . '", ' .
        '"estado": "' . $this->estado . '", ' .
        '"prioridad": "' . $this->prioridad . '"' .
    '}';
    }
}
