<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable{

    private $departamento;
    private $bono = 0;

    public function __construct($nombre, $id_empleado, $sal_base, $departamento) {
        parent::__construct($nombre, $id_empleado, $sal_base);
        $this->departamento = $departamento;
    }

    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    public function asignarBono($monto) {
        $this->bono = (float)$monto;
    }

    public function getSalarioTotal() {
        return $this->getSalarioBase() + $this->bono;
    }

    public function evaluarDesempenio()
    {
        if ($this->bono > 1000){
            return "Exelente";
        }elseif ($this->bono > 500){
            return "Bueno";
        }else{
            return "Regular";
        }
    }
}
?>