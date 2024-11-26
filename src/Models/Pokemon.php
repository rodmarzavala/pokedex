<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Models;

use Rodmar\Pokedex\Exceptions\EvolucionNoPosibleException;

class Pokemon
{
    private string $nombre;
    private string $tipo;
    private int $nivel;
    private ?array $evolucion;

    public function __construct(
        string $nombre,
        string $tipo,
        int $nivel = 1,
        ?array $evolucion = null
    ) {
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->nivel = $nivel;
        $this->evolucion = $evolucion;
    }

    final public function getNombre(): string
    {
        return $this->nombre;
    }

    final public function getTipo(): string
    {
        return $this->tipo;
    }

    final public function getNivel(): int
    {
        return $this->nivel;
    }

    final public function subirNivel(): void
    {
        $this->nivel++;
    }

    final public function puedeEvolucionar(): bool
    {
        if ($this->evolucion === null) {
            return false;
        }

        return $this->nivel >= $this->evolucion['nivel_minimo'];
    }

    /**
     * @throws EvolucionNoPosibleException
     */
    final public function evolucionar(): void
    {
        if ($this->puedeEvolucionar()) {
            $this->nombre = $this->evolucion['nombre_evolucion'];
            $this->evolucion = null; // Asumimos que solo evoluciona una vez
            echo "{$this->getNombre()} ha evolucionado!" . PHP_EOL;
        } else {
            throw new EvolucionNoPosibleException("El Pokémon {$this->getNombre()} no puede evolucionar.");
        }
    }

    final public function getEvolucion(): ?array
    {
        return $this->evolucion;
    }
}
