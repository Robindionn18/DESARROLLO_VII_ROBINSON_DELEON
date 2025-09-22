<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Desarrollador extends Empleado implements Evaluable
{
    protected $lenguajePrincipal;
    protected $nivel;

    public function __construct(string $nombre, int $idEmpleado, float $salarioBase, string $lenguaje, string $nivel)
    {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->lenguajePrincipal = $lenguaje;
        $this->nivel = strtolower($nivel);
    }

    public function getLenguajePrincipal(): string { return $this->lenguajePrincipal; }
    public function setLenguajePrincipal(string $l): void { $this->lenguajePrincipal = $l; }

    public function getNivel(): string { return $this->nivel; }
    public function setNivel(string $n): void { $this->nivel = strtolower($n); }

    public function evaluarDesempeno(): int
    {
        switch ($this->nivel) {
            case 'senior': return 5;
            case 'mid': return 4;
            case 'junior': return 2;
            default: return 3;
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'lenguajePrincipal' => $this->lenguajePrincipal,
            'nivel' => $this->nivel,
        ]);
    }

    public static function fromArray(array $data): self
    {
        return new self($data['nombre'], (int)$data['idEmpleado'], (float)$data['salarioBase'], $data['lenguajePrincipal'] ?? '', $data['nivel'] ?? '');
    }
}
