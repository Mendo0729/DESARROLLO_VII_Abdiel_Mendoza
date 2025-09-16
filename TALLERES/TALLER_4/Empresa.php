<?php

class Empresa {
    private $nombre;
    private $empleados;

    public function __construct($nombre) {
        $this->nombre = $nombre;
        $this->empleados = array();
    }

    public function agregarEmpleado($empleado) {
        $this->empleados[] = $empleado;
    }

    public function obtenerEmpleados() {
        return $this->empleados;
    }

    public function obtenerNombre() {
        return $this->nombre;
    }

    public function listarEmpleados(){
        foreach ($this->empleados as $empleado){
            echo "Empleado: " . $empleado->getNombre() . " | ID: " . $empleado->getIdEmpleado() . "\n";
        }
    }

    public function calcularTotalNomina() {
        $total = 0;
        foreach ($this->empleados as $empleado) {
            if (method_exists($empleado, "getSalarioTotal")) {
                $total += $empleado->getSalarioTotal();
            } else {
                $total += $empleado->getSalarioBase();
            }
        }
        return $total;
    }

    public function evaluarDesempeno() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo "Empleado " . $empleado->getNombre() . " - Desempeño: " . $empleado->evaluarDesempenio() . "\n";
            } else {
                echo "Empleado " . $empleado->getNombre() . " no es evaluable.\n";
            }
        }
    }
}
