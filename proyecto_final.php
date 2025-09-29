<?php
declare(strict_types=1);



class EstudianteNotFoundException extends Exception {}
class InvalidDataException extends Exception {}

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
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];

        // validar e inicializar materias si se pasan
        foreach ($materias as $materia => $calificacion) {
            $this->agregarMateria((string)$materia, (float)$calificacion);
        }
    }

    // Getters
    public function getId(): int { return $this->id; }
    public function getNombre(): string { return $this->nombre; }
    public function getEdad(): int { return $this->edad; }
    public function getCarrera(): string { return $this->carrera; }
    public function getMaterias(): array { return $this->materias; }
    public function getFlags(): array { return $this->flags; }

    // Setters (si necesitas modificar)
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setEdad(int $edad): void { $this->edad = $edad; }
    public function setCarrera(string $carrera): void { $this->carrera = $carrera; }

    /**
     * Añade o actualiza una materia con su calificación.
     * Valida calificaciones entre 0 y 100.
     */
    public function agregarMateria(string $materia, float $calificacion): void
    {
        if ($calificacion < 0.0 || $calificacion > 100.0) {
            throw new InvalidDataException("Calificación inválida para $materia: $calificacion (debe estar entre 0 y 100).");
        }
        $this->materias[$materia] = $calificacion;
    }

    /**
     * Calcula el promedio de calificaciones del estudiante.
     * Retorna 0 si no tiene materias (para evitar división por cero).
     */
    public function obtenerPromedio(): float
    {
        if (empty($this->materias)) {
            return 0.0;
        }
        // usar array_reduce como requisito
        $suma = array_reduce(array_values($this->materias), function($carry, $item) {
            return $carry + $item;
        }, 0.0);
        return $suma / count($this->materias);
    }

    /**
     * Retorna un arreglo asociativo con toda la información del estudiante.
     */
    public function obtenerDetalles(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'promedio' => round($this->obtenerPromedio(), 2),
            'flags' => $this->flags
        ];
    }

    /**
     * Marca o desmarca flags (por ejemplo 'en riesgo académico').
     */
    public function setFlag(string $flagName, bool $valor = true): void
    {
        if ($valor) {
            $this->flags[$flagName] = true;
        } else {
            unset($this->flags[$flagName]);
        }
    }

    /**
     * Implementación de __toString para imprimir información legible.
     */
    public function __toString(): string
    {
        $prom = round($this->obtenerPromedio(), 2);
        $materiasList = [];
        foreach ($this->materias as $m => $c) {
            $materiasList[] = "$m: $c";
        }
        $flagsList = empty($this->flags) ? 'Ninguno' : implode(', ', array_keys($this->flags));
        return "Estudiante [ID: {$this->id}] {$this->nombre} | Edad: {$this->edad} | Carrera: {$this->carrera} | Promedio: {$prom} | Flags: {$flagsList} \n  Materias: " . implode(' | ', $materiasList);
    }

    /**
     * Serialización a array para persistencia JSON
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias,
            'flags' => array_keys($this->flags)
        ];
    }

    /**
     * Crear Estudiante desde array (para carga JSON)
     */
    public static function fromArray(array $data): Estudiante
    {
        $id = (int)($data['id'] ?? 0);
        $nombre = (string)($data['nombre'] ?? '');
        $edad = (int)($data['edad'] ?? 0);
        $carrera = (string)($data['carrera'] ?? '');
        $materias = (array)($data['materias'] ?? []);
        $est = new Estudiante($id, $nombre, $edad, $carrera, $materias);
        if (!empty($data['flags']) && is_array($data['flags'])) {
            foreach ($data['flags'] as $flag) {
                $est->setFlag((string)$flag, true);
            }
        }
        return $est;
    }
}

class SistemaGestionEstudiantes
{
    /** @var Estudiante[] */
    private array $estudiantes = [];
    /** @var Estudiante[] graduados */
    private array $graduados = [];

    /**
     * Agrega un estudiante (objeto Estudiante).
     * Reemplaza si el ID ya existe.
     */
    public function agregarEstudiante(Estudiante $est): void
    {
        $this->estudiantes[$est->getId()] = $est;
    }

    /**
     * Obtiene un estudiante por ID. Lanza excepción si no existe.
     */
    public function obtenerEstudiante(int $id): Estudiante
    {
        if (!isset($this->estudiantes[$id])) {
            throw new EstudianteNotFoundException("Estudiante con ID $id no encontrado.");
        }
        return $this->estudiantes[$id];
    }

    /**
     * Retorna arreglo con todos los estudiantes (objetos).
     */
    public function listarEstudiantes(): array
    {
        return array_values($this->estudiantes);
    }

    /**
     * Calcula el promedio general (promedio de promedios) usando array_map y array_reduce.
     */
    public function calcularPromedioGeneral(): float
    {
        $lista = $this->listarEstudiantes();
        if (empty($lista)) { return 0.0; }

        $promedios = array_map(function(Estudiante $e) { return $e->obtenerPromedio(); }, $lista);
        $suma = array_reduce($promedios, fn($carry, $p) => $carry + $p, 0.0);
        return $suma / count($promedios);
    }

    /**
     * Retorna estudiantes de una carrera específica (case-insensitive).
     */
    public function obtenerEstudiantesPorCarrera(string $carrera): array
    {
        $carreraLower = mb_strtolower($carrera);
        return array_values(array_filter($this->estudiantes, function(Estudiante $e) use ($carreraLower) {
            return mb_strtolower($e->getCarrera()) === $carreraLower;
        }));
    }

    /**
     * Retorna el estudiante con el promedio más alto.
     * Devuelve null si no hay estudiantes.
     */
    public function obtenerMejorEstudiante(): ?Estudiante
    {
        $lista = $this->listarEstudiantes();
        if (empty($lista)) { return null; }
        usort($lista, fn(Estudiante $a, Estudiante $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $lista[0];
    }

    /**
     * Genera reporte por materia: para cada materia
     * - promedio
     * - calificación más alta
     * - calificación más baja
     *
     * Recuerda que no todos los estudiantes tienen todas las materias, por eso usamos agregación.
     */
    public function generarReporteRendimiento(): array
    {
        $datosPorMateria = []; // 'Matemáticas' => ['valores' => [90,80,...]]
        foreach ($this->estudiantes as $est) {
            foreach ($est->getMaterias() as $materia => $calificacion) {
                if (!isset($datosPorMateria[$materia])) {
                    $datosPorMateria[$materia] = [];
                }
                $datosPorMateria[$materia][] = $calificacion;
            }
        }

        $reporte = [];
        foreach ($datosPorMateria as $materia => $valores) {
            $suma = array_reduce($valores, fn($c,$i) => $c + $i, 0.0);
            $reporte[$materia] = [
                'promedio' => round($suma / count($valores), 2),
                'max' => max($valores),
                'min' => min($valores),
                'num_registros' => count($valores)
            ];
        }

        return $reporte;
    }

    /**
     * "Gradúa" a un estudiante: lo elimina del arreglo principal y lo añade a graduados.
     */
    public function graduarEstudiante(int $id): void
    {
        if (!isset($this->estudiantes[$id])) {
            throw new EstudianteNotFoundException("No se puede graduar: estudiante con ID $id no encontrado.");
        }
        $this->graduados[$id] = $this->estudiantes[$id];
        unset($this->estudiantes[$id]);
    }

    /**
     * Genera un ranking (arreglo ordenado) por promedio, de mayor a menor.
     * Retorna arreglo de arrays con id, nombre, promedio.
     */
    public function generarRanking(): array
    {
        $lista = $this->listarEstudiantes();
        usort($lista, fn(Estudiante $a, Estudiante $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return array_map(function(Estudiante $e) {
            return [
                'id' => $e->getId(),
                'nombre' => $e->getNombre(),
                'carrera' => $e->getCarrera(),
                'promedio' => round($e->obtenerPromedio(), 2)
            ];
        }, $lista);
    }

    /**
     * Búsqueda parcial insensible a mayúsculas por nombre o carrera.
     * Retorna arreglo de Estudiante (coincidencias).
     */
    public function buscar(string $termino): array
    {
        $t = mb_strtolower($termino);
        return array_values(array_filter($this->estudiantes, function(Estudiante $e) use ($t) {
            return (mb_stripos(mb_strtolower($e->getNombre()), $t) !== false)
                || (mb_stripos(mb_strtolower($e->getCarrera()), $t) !== false);
        }));
    }

    /**
     * Genera estadísticas por carrera:
     * - número de estudiantes
     * - promedio general de la carrera
     * - mejor estudiante de la carrera
     */
    public function estadisticasPorCarrera(): array
    {
        $porCarrera = [];
        foreach ($this->estudiantes as $est) {
            $c = $est->getCarrera();
            if (!isset($porCarrera[$c])) {
                $porCarrera[$c] = [];
            }
            $porCarrera[$c][] = $est;
        }

        $res = [];
        foreach ($porCarrera as $carrera => $estList) {
            $num = count($estList);
            $promedios = array_map(fn(Estudiante $e) => $e->obtenerPromedio(), $estList);
            $promedioCarrera = count($promedios) ? (array_reduce($promedios, fn($a,$b) => $a+$b, 0.0) / count($promedios)) : 0.0;
            usort($estList, fn(Estudiante $a, Estudiante $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
            $mejor = $estList[0] ?? null;
            $res[$carrera] = [
                'numero_estudiantes' => $num,
                'promedio_general' => round($promedioCarrera, 2),
                'mejor_estudiante' => $mejor ? $mejor->obtenerDetalles() : null
            ];
        }

        return $res;
    }

    /**
     * Aplica flags automáticos a los estudiantes basados en reglas:
     * - 'en riesgo académico' si promedio < 60 o tiene al menos 1 reprobada (<60)
     * - 'honor roll' si promedio >= 90
     * - 'remedial' si tiene 2 o más materias reprobadas
     */
    public function aplicarFlags(): void
    {
        foreach ($this->estudiantes as $est) {
            $prom = $est->obtenerPromedio();
            $reprobadas = array_filter($est->getMaterias(), fn($cal) => $cal < 60.0);
            $numReprobadas = count($reprobadas);

            // limpiar flags anteriores de estas categorías
            foreach (['en riesgo académico','honor roll','remedial'] as $f) {
                $est->setFlag($f, false);
            }

            if ($prom < 60.0 || $numReprobadas >= 1) {
                $est->setFlag('en riesgo académico', true);
            }
            if ($prom >= 90.0) {
                $est->setFlag('honor roll', true);
            }
            if ($numReprobadas >= 2) {
                $est->setFlag('remedial', true);
            }
        }
    }

    /**
     * Guardar y cargar en JSON (persistencia simple).
     */
    public function guardarJSON(string $ruta): void
    {
        $arr = [
            'estudiantes' => array_map(fn(Estudiante $e) => $e->toArray(), $this->listarEstudiantes()),
            'graduados' => array_map(fn(Estudiante $e) => $e->toArray(), array_values($this->graduados))
        ];
        $json = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($json === false) {
            throw new Exception("Error al serializar a JSON.");
        }
        file_put_contents($ruta, $json);
    }

    public function cargarJSON(string $ruta): void
    {
        if (!file_exists($ruta)) {
            throw new Exception("Archivo $ruta no encontrado.");
        }
        $json = file_get_contents($ruta);
        $data = json_decode($json, true);
        if (!is_array($data)) {
            throw new Exception("Formato JSON inválido en $ruta.");
        }
        $this->estudiantes = [];
        $this->graduados = [];
        foreach ($data['estudiantes'] ?? [] as $estArr) {
            $est = Estudiante::fromArray($estArr);
            $this->agregarEstudiante($est);
        }
        foreach ($data['graduados'] ?? [] as $estArr) {
            $this->graduados[$estArr['id']] = Estudiante::fromArray($estArr);
        }
    }

    /**
     * Obtener graduados
     */
    public function listarGraduados(): array
    {
        return array_values($this->graduados);
    }
}

/* -----------------------
   SECCIÓN DE PRUEBAS
   ----------------------- */

// Instanciamos el sistema
$sistema = new SistemaGestionEstudiantes();

// Creamos 10 estudiantes con diferentes carreras, edades y calificaciones
$datos = [
    [1, 'Ana Gómez', 20, 'Ingeniería', ['Matemáticas'=>95, 'Física'=>88, 'Programación'=>92]],
    [2, 'Carlos Pérez', 22, 'Economía', ['Microeconomía'=>78, 'Macroeconomía'=>82, 'Matemáticas'=>70]],
    [3, 'María Torres', 19, 'Medicina', ['Anatomía'=>85, 'Biología'=>90, 'Química'=>87]],
    [4, 'Luis Herrera', 23, 'Ingeniería', ['Matemáticas'=>55, 'Física'=>58, 'Programación'=>65]],
    [5, 'Sofía López', 21, 'Derecho', ['Introducción Derecho'=>88, 'Historia'=>92]],
    [6, 'Jorge Martínez', 20, 'Economía', ['Microeconomía'=>60, 'Matemáticas'=>59]],
    [7, 'Camila Ruiz', 18, 'Ingeniería', ['Matemáticas'=>99, 'Física'=>94, 'Programación'=>98]],
    [8, 'Diego Morales', 24, 'Medicina', ['Anatomía'=>76, 'Biología'=>70, 'Química'=>65]],
    [9, 'Lucía Fernández', 22, 'Derecho', ['Introducción Derecho'=>58, 'Historia'=>61]],
    [10,'Mateo Castillo', 20, 'Ingeniería', ['Matemáticas'=>82, 'Física'=>80, 'Programación'=>75]],
];

// Añadir al sistema usando un bucle
foreach ($datos as [$id, $nombre, $edad, $carrera, $materias]) {
    $est = new Estudiante($id, $nombre, $edad, $carrera, $materias);
    $sistema->agregarEstudiante($est);
}

// Mostrar todos los estudiantes
echo "=== LISTA DE ESTUDIANTES ===\n";
foreach ($sistema->listarEstudiantes() as $est) {
    echo $est . "\n";
}

// Calcular promedio general
echo "\n=== PROMEDIO GENERAL DEL SISTEMA ===\n";
echo round($sistema->calcularPromedioGeneral(), 2) . "\n";

// Obtener estudiantes por carrera
echo "\n=== ESTUDIANTES POR CARRERA: Ingeniería ===\n";
foreach ($sistema->obtenerEstudiantesPorCarrera('ingeniería') as $e) {
    echo "- {$e->getNombre()} (Promedio: " . round($e->obtenerPromedio(),2) . ")\n";
}

// Mejor estudiante
$mejor = $sistema->obtenerMejorEstudiante();
echo "\n=== MEJOR ESTUDIANTE ===\n";
if ($mejor) {
    echo $mejor . "\n";
}

// Generar ranking
echo "\n=== RANKING ===\n";
$ranking = $sistema->generarRanking();
$pos = 1;
foreach ($ranking as $r) {
    echo "{$pos}. {$r['nombre']} ({$r['carrera']}) - Promedio: {$r['promedio']}\n";
    $pos++;
}

// Generar reporte por materia
echo "\n=== REPORTE POR MATERIA ===\n";
$reporte = $sistema->generarReporteRendimiento();
foreach ($reporte as $materia => $info) {
    echo "- $materia: Promedio {$info['promedio']} | Max: {$info['max']} | Min: {$info['min']} | Registros: {$info['num_registros']}\n";
}

// Buscar por término parcial
echo "\n=== BÚSQUEDA: término 'mar' (debería encontrar María y Mateo si coincide) ===\n";
$resultados = $sistema->buscar('mar');
foreach ($resultados as $r) {
    echo "- {$r->getNombre()} (Carrera: {$r->getCarrera()})\n";
}

// Estadísticas por carrera
echo "\n=== ESTADÍSTICAS POR CARRERA ===\n";
$estad = $sistema->estadisticasPorCarrera();
foreach ($estad as $carrera => $info) {
    echo "Carrera: $carrera\n";
    echo "  Número de estudiantes: {$info['numero_estudiantes']}\n";
    echo "  Promedio general: {$info['promedio_general']}\n";
    $mej = $info['mejor_estudiante'];
    echo "  Mejor estudiante: " . ($mej ? ($mej['nombre'] . " (Promedio: " . $mej['promedio'] . ")") : "N/A") . "\n";
}

// Aplicar flags
$sistema->aplicarFlags();
echo "\n=== FLAGS APLICADOS ===\n";
foreach ($sistema->listarEstudiantes() as $e) {
    $flags = $e->getFlags();
    $flagsText = empty($flags) ? 'Ninguno' : implode(', ', array_keys($flags));
    echo "- {$e->getNombre()} -> Flags: $flagsText\n";
}

// Graduar un estudiante y mostrar lista de graduados
echo "\n=== GRADUAR ESTUDIANTE ID 2 (Carlos Pérez) ===\n";
try {
    $sistema->graduarEstudiante(2);
    echo "Graduado con éxito.\n";
} catch (Exception $ex) {
    echo "Error: " . $ex->getMessage() . "\n";
}

echo "\nEstudiantes actuales:\n";
foreach ($sistema->listarEstudiantes() as $e) {
    echo "- {$e->getNombre()}\n";
}

echo "\nGraduados:\n";
foreach ($sistema->listarGraduados() as $g) {
    echo "- {$g->getNombre()} (Promedio: " . round($g->obtenerPromedio(),2) . ")\n";
}

// Guardar a JSON (persistencia simple)
$rutaJSON = __DIR__ . '/taller5_estudiantes.json';
try {
    $sistema->guardarJSON($rutaJSON);
    echo "\nDatos guardados en JSON: $rutaJSON\n";
} catch (Exception $ex) {
    echo "Error guardando JSON: " . $ex->getMessage() . "\n";
}

// Demostración de carga (crear nuevo sistema y cargar)
echo "\n=== DEMOSTRACIÓN CARGA JSON EN NUEVO SISTEMA ===\n";
$sistema2 = new SistemaGestionEstudiantes();
try {
    $sistema2->cargarJSON($rutaJSON);
    echo "Carga exitosa. Estudiantes cargados:\n";
    foreach ($sistema2->listarEstudiantes() as $est) {
        echo "- {$est->getNombre()} (ID {$est->getId()})\n";
    }
} catch (Exception $ex) {
    echo "Error al cargar JSON: " . $ex->getMessage() . "\n";
}

echo "\n=== FIN DE PRUEBAS ===\n";
