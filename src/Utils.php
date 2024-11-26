<?php

declare(strict_types=1);

namespace Rodmar\Pokedex;

use Rodmar\Pokedex\Models\Pokemon;

final class Utils
{
    public static function mostrarInfo(Pokemon $pokemon): void
    {
        echo "Nombre: " . $pokemon->getNombre() . PHP_EOL;
        echo "Tipo: " . $pokemon->getTipo() . PHP_EOL;
        echo "Nivel: " . $pokemon->getNivel() . PHP_EOL;
        if ($pokemon->puedeEvolucionar()) {
            echo "Este Pokémon puede evolucionar." . PHP_EOL;
        } else {
            echo "Este Pokémon no puede evolucionar." . PHP_EOL;
        }
    }
}
