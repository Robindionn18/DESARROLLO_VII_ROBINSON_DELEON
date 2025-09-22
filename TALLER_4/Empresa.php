<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';
require_once 'Gerente.php';
require_once 'Desarrollador.php';

class Empresa
{
    protected $empleados = [];

    public function agregarEmpleado(Empleado $e): void
    {
        $this->empleados[$e->getIdEmpleado()] = $e;
    }

    public function listarEmpleados(): array
    {
        return array_values($this->empleados);
    }

    public function calcularNominaTotal(): float
    {
        $total = 0.0;
        foreach ($this->empleados as $e) {
            $total += $e->getSalarioBase();
            if ($e instanceof Gerente) $total += $e->getBono();
        }
        return $total;
    }

    public function evaluarDesempenoTodos(bool $aplicarAumento = false): array
    {
        $resultados = [];
        foreach ($this->empleados as $e) {
            if ($e instanceof Evaluable) {
                $score = $e->evaluarDesempeno();
                if ($e instanceof Empleado) {
                    $resultados[$e->getIdEmpleado()] = $score;
                    if ($aplicarAumento) $this->aplicarAumentoSegunScore($e, $score);
                }
            }
        }
        return $resultados;
    }

    protected function aplicarAumentoSegunScore(Empleado $e, int $score): void
    {
        $map = [1 => 0.0, 2 => 0.01, 3 => 0.03, 4 => 0.05, 5 => 0.08];
        $pct = $map[$score] ?? 0.0;
        $e->setSalarioBase($e->getSalarioBase() * (1 + $pct));
    }

    public function listarPorDepartamento(string $departamento): array
    {
        $out = [];
        foreach ($this->empleados as $e) {
            if ($e instanceof Gerente && strcasecmp($e->getDepartamento(), $departamento) === 0) {
                $out[] = $e;
            }
        }
        return $out;
    }

    public function salarioPromedioPorTipo(string $tipoClass): float
    {
        $suma = 0.0; $count = 0;
        foreach ($this->empleados as $e) {
            if (get_class($e) === $tipoClass || is_subclass_of($e, $tipoClass)) {
                $suma += $e->getSalarioBase();
                $count++;
            }
        }
        return $count > 0 ? $suma / $count : 0.0;
    }

    public function guardarEnArchivo(string $ruta): bool
    {
        $arr = [];
        foreach ($this->empleados as $e) {
            $arr[] = $e->toArray();
        }
        $json = json_encode($arr, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return (bool)file_put_contents($ruta, $json);
    }

    public function cargarDesdeArchivo(string $ruta): bool
    {
        if (!file_exists($ruta)) return false;
        $json = file_get_contents($ruta);
        $arr = json_decode($json, true);
        if (!is_array($arr)) return false;

        $this->empleados = [];
        foreach ($arr as $item) {
            $class = $item['class'] ?? null;
            if ($class === 'Gerente') $obj = Gerente::fromArray($item);
            elseif ($class === 'Desarrollador') $obj = Desarrollador::fromArray($item);
            else $obj = Empleado::fromArray($item);
            $this->agregarEmpleado($obj);
        }
        return true;
    }
}
