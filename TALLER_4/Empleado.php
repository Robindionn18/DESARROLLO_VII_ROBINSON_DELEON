<?php
class Empleado
{
    protected $nombre;
    protected $idEmpleado;
    protected $salarioBase;

    public function __construct(string $nombre, int $idEmpleado, float $salarioBase)
    {
        $this->nombre = $nombre;
        $this->idEmpleado = $idEmpleado;
        $this->salarioBase = $salarioBase;
    }

    public function getNombre(): string { return $this->nombre; }
    public function getIdEmpleado(): int { return $this->idEmpleado; }
    public function getSalarioBase(): float { return $this->salarioBase; }

    public function setNombre(string $nombre): void { $this->nombre = $nombre; }
    public function setIdEmpleado(int $id): void { $this->idEmpleado = $id; }
    public function setSalarioBase(float $salario): void { $this->salarioBase = $salario; }

    public function toArray(): array
    {
        return [
            'class' => static::class,
            'nombre' => $this->nombre,
            'idEmpleado' => $this->idEmpleado,
            'salarioBase' => $this->salarioBase,
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self($data['nombre'], (int)$data['idEmpleado'], (float)$data['salarioBase']);
    }
}
