<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable
{
    protected $departamento;
    protected $bono = 0.0;

    public function __construct(string $nombre, int $idEmpleado, float $salarioBase, string $departamento)
    {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
    }

    public function getDepartamento(): string { return $this->departamento; }
    public function setDepartamento(string $d): void { $this->departamento = $d; }

    public function asignarBono(float $monto): void { $this->bono = $monto; }
    public function getBono(): float { return $this->bono; }

    public function evaluarDesempeno(): int
    {
        if ($this->bono >= 3000) return 5;
        if ($this->bono >= 1500) return 4;
        if ($this->bono > 0) return 3;
        return 2;
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'departamento' => $this->departamento,
            'bono' => $this->bono,
        ]);
    }

    public static function fromArray(array $data): self
    {
        $obj = new self($data['nombre'], (int)$data['idEmpleado'], (float)$data['salarioBase'], $data['departamento'] ?? '');
        $obj->asignarBono((float)($data['bono'] ?? 0));
        return $obj;
    }
}
