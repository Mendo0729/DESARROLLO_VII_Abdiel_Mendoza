<?php
class Empleado{
    public $nombre;
    public $id_empleado;
    public $sal_base;

    public function __construct($nombre, $id_empleado, $sal_base) {
        $this->nombre = $nombre;
        $this->id_empleado = $id_empleado;
        $this->sal_base = $sal_base;
    }

    public function getNombre(){
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = trim($nombre);
    }

    public function getIdEmpleado(){
        return $this->id_empleado;
    }

    public function setIdEmpleado($id_empleado) {
        $this->id_empleado = trim($id_empleado);
    }

    public function getSalarioBase(){
        return $this->sal_base;
    }

    public function setSalarioBase($sal_base) {
        $this->sal_base = trim($sal_base);
    }
}
?>