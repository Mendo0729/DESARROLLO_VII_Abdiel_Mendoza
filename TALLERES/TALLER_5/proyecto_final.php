<?php
// Clase Estudiante
class Estudiante
{
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias;
    private array $flags = [];

    public function __construct(int $id, string $nombre, int $edad, string $carrera, array $materias = [])
    {
        if ($edad < 16 || $edad > 100) throw new Exception("Edad inválida: $edad");
        foreach ($materias as $mat => $nota) {
            if ($nota < 0 || $nota > 100) throw new Exception("Calificación inválida en $mat: $nota");
        }

        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = $materias;
        $this->actualizarFlags();
    }

    public function agregarMateria(string $materia, float $calificacion): void
    {
        if ($calificacion < 0 || $calificacion > 100) throw new Exception("Calificación inválida: $calificacion");
        $this->materias[$materia] = $calificacion;
        $this->actualizarFlags();
    }

    public function obtenerPromedio(): float
    {
        if (empty($this->materias)) return 0;
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'flags' => $this->flags
        ];
    }

    private function actualizarFlags(): void
    {
        $promedio = $this->obtenerPromedio();
        $this->flags = [];
        if ($promedio >= 90) $this->flags[] = 'honor roll';
        if ($promedio < 70) $this->flags[] = 'en riesgo académico';
        foreach ($this->materias as $nota) {
            if ($nota < 60 && !in_array('en riesgo académico', $this->flags)) {
                $this->flags[] = 'en riesgo académico';
                break;
            }
        }
    }

    public function __toString(): string
    {
        $materiasStr = '';
        foreach ($this->materias as $mat => $nota) $materiasStr .= "$mat: $nota, ";
        $materiasStr = rtrim($materiasStr, ", ");
        $flagsStr = implode(", ", $this->flags);
        return "ID: {$this->id}, Nombre: {$this->nombre}, Edad: {$this->edad}, Carrera: {$this->carrera}, Promedio: " . number_format($this->obtenerPromedio(), 2) . ", Materias: [$materiasStr], Flags: [$flagsStr]\n";
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }
    public function getCarrera(): string
    {
        return $this->carrera;
    }
}

// Clase SistemaGestionEstudiantes

class SistemaGestionEstudiantes
{
    private array $estudiantes = [];
    private array $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante): void
    {
        $this->estudiantes[] = $estudiante;
    }

    public function obtenerEstudiante(int $id): ?Estudiante
    {
        foreach ($this->estudiantes as $e) if ($e->getId() === $id) return $e;
        return null;
    }

    public function listarEstudiantes(): array
    {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral(): float
    {
        if (empty($this->estudiantes)) return 0;
        $promedios = array_map(fn($e) => $e->obtenerPromedio(), $this->estudiantes);
        return array_sum($promedios) / count($promedios);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera): array
    {
        return array_filter($this->estudiantes, fn($e) => strcasecmp($e->getCarrera(), $carrera) === 0);
    }

    public function obtenerMejorEstudiante(): ?Estudiante
    {
        if (empty($this->estudiantes)) return null;
        return array_reduce($this->estudiantes, fn($mejor, $e) => (!$mejor || $e->obtenerPromedio() > $mejor->obtenerPromedio()) ? $e : $mejor);
    }

    public function generarReporteRendimiento(): array
    {
        $materias = [];
        foreach ($this->estudiantes as $e) {
            foreach ($e->obtenerDetalles()['materias'] as $mat => $nota) {
                $materias[$mat][] = $nota;
            }
        }
        $reporte = [];
        foreach ($materias as $mat => $notas) {
            $reporte[$mat] = [
                'promedio' => array_sum($notas) / count($notas),
                'max' => max($notas),
                'min' => min($notas)
            ];
        }
        return $reporte;
    }

    public function graduarEstudiante(int $id): void
    {
        foreach ($this->estudiantes as $k => $e) {
            if ($e->getId() === $id) {
                $this->graduados[] = $e;
                unset($this->estudiantes[$k]);
                $this->estudiantes = array_values($this->estudiantes);
                return;
            }
        }
        throw new Exception("Estudiante con ID $id no encontrado.");
    }

    public function generarRanking(): array
    {
        $ranking = $this->estudiantes;
        usort($ranking, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $ranking;
    }

    public function buscarEstudiantes(string $termino): array
    {
        $termino = strtolower($termino);
        return array_filter(
            $this->estudiantes,
            fn($e) =>
            str_contains(strtolower($e->getNombre()), $termino) || str_contains(strtolower($e->getCarrera()), $termino)
        );
    }

public function estadisticasPorCarrera(): array
{
    $carreras = [];
    foreach ($this->estudiantes as $e) {
        $c = $e->getCarrera();
        if (!isset($carreras[$c])) {
            $carreras[$c] = [
                'estudiantes' => 0,
                'promedioGeneral' => 0,
                'mejor' => $e
            ];
        }

        $carreras[$c]['estudiantes'] += 1;
        $carreras[$c]['promedioGeneral'] += $e->obtenerPromedio();

        if ($e->obtenerPromedio() > $carreras[$c]['mejor']->obtenerPromedio()) {
            $carreras[$c]['mejor'] = $e;
        }
    }

    foreach ($carreras as $c => $stats) {
        $carreras[$c]['promedioGeneral'] = $stats['promedioGeneral'] / $stats['estudiantes'];
    }

    return $carreras;
}



    // Guardado en el JSON

    public function guardarEnArchivo(string $archivo): void
    {
        $data = array_map(fn($e) => $e->obtenerDetalles(), $this->estudiantes);
        file_put_contents($archivo, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function cargarDesdeArchivo(string $archivo): void
    {
        if (!file_exists($archivo)) return;
        $data = json_decode(file_get_contents($archivo), true);
        foreach ($data as $estudianteData) {
            $est = new Estudiante(
                $estudianteData['id'],
                $estudianteData['nombre'],
                $estudianteData['edad'],
                $estudianteData['carrera'],
                $estudianteData['materias']
            );
            $this->agregarEstudiante($est);
        }
    }
}


// Sección de prueba

$sistemaEstudiantes = new SistemaGestionEstudiantes();

$estudiantesPrueba = [
    new Estudiante(1, "Ana", 20, "Ingeniería", ["Matemáticas" => 90, "Física" => 85]),
    new Estudiante(2, "Juan", 21, "Arquitectura", ["Dibujo" => 80, "Historia" => 75]),
    new Estudiante(3, "María", 19, "Medicina", ["Anatomía" => 95, "Química" => 92]),
    new Estudiante(4, "Pedro", 22, "Ingeniería", ["Matemáticas" => 70, "Física" => 65]),
    new Estudiante(5, "Laura", 20, "Derecho", ["Derecho Civil" => 88, "Ética" => 92]),
    new Estudiante(6, "Carlos", 23, "Arquitectura", ["Dibujo" => 85, "Historia" => 78]),
    new Estudiante(7, "Lucía", 21, "Medicina", ["Anatomía" => 89, "Química" => 94]),
    new Estudiante(8, "Diego", 22, "Ingeniería", ["Matemáticas" => 95, "Física" => 90]),
    new Estudiante(9, "Sofía", 20, "Derecho", ["Derecho Civil" => 82, "Ética" => 80]),
    new Estudiante(10, "Miguel", 24, "Arquitectura", ["Dibujo" => 92, "Historia" => 88]),
];

foreach ($estudiantesPrueba as $e) $sistemaEstudiantes->agregarEstudiante($e);


// Menú 
function menuCLI(SistemaGestionEstudiantes $sistema)
{
    do {
        echo "\n--- Sistema Gestión Estudiantes ---\n";
        echo "1. Listar estudiantes\n";
        echo "2. Agregar estudiante\n";
        echo "3. Buscar estudiante\n";
        echo "4. Generar reportes\n";
        echo "5. Guardar estudiantes\n";
        echo "6. Cargar estudiantes\n";
        echo "7. Salir\n";
        $op = readline("Seleccione una opción: ");

        switch ($op) {
            case 1:
                foreach ($sistema->listarEstudiantes() as $e) echo $e;
                break;
            case 2:
                try {
                    $id = (int)readline("ID: ");
                    $nombre = readline("Nombre: ");
                    $edad = (int)readline("Edad: ");
                    $carrera = readline("Carrera: ");
                    $materias = [];
                    do {
                        $materia = readline("Materia (dejar vacío para terminar): ");
                        if ($materia === "") break;
                        $calificacion = (float)readline("Calificación: ");
                        $materias[$materia] = $calificacion;
                    } while (true);
                    $sistema->agregarEstudiante(new Estudiante($id, $nombre, $edad, $carrera, $materias));
                } catch (Exception $ex) {
                    echo "Error: " . $ex->getMessage() . "\n";
                }
                break;
            case 3:
                $termino = readline("Ingrese nombre o carrera: ");
                $result = $sistema->buscarEstudiantes($termino);
                foreach ($result as $e) echo $e;
                break;
            case 4:
                echo "Promedio General: " . number_format($sistema->calcularPromedioGeneral(), 2) . "\n";
                $mejor = $sistema->obtenerMejorEstudiante();
                echo "Mejor Estudiante: " . $mejor . "\n";
                echo "Ranking:\n";
                foreach ($sistema->generarRanking() as $e) echo $e;
                echo "Reporte por materias:\n";
                print_r($sistema->generarReporteRendimiento());
                break;
            case 5:
                $archivo = readline("Nombre del archivo para guardar: ");
                $sistema->guardarEnArchivo($archivo);
                echo "Estudiantes guardados en $archivo\n";
                break;
            case 6:
                $archivo = readline("Nombre del archivo para cargar: ");
                $sistema->cargarDesdeArchivo($archivo);
                echo "Estudiantes cargados desde $archivo\n";
                break;
        }
    } while ($op != 7);
}

menuCLI($sistemaEstudiantes);
