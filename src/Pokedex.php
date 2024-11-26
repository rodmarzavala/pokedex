<?php

declare(strict_types=1);

namespace Rodmar\Pokedex;

use Rodmar\Pokedex\Models\Pokemon;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Rodmar\Pokedex\Database\JsonDatabase;

final class Pokedex
{
    private array $listaPokemon = [];
    private JsonDatabase $database;

    public function __construct(JsonDatabase $database)
    {
        $this->database = $database;
        $this->cargarPokemon();
    }

    private function cargarPokemon(): void
    {
        $pokemonDataList = $this->database->getAllPokemon();

        foreach ($pokemonDataList as $pokemonData) {
            $pokemon = new Pokemon(
                $pokemonData['nombre'],
                $pokemonData['tipo'],
                $pokemonData['nivel'],
                $pokemonData['evolucion'] ?? null
            );

            $this->agregarPokemon($pokemon);
        }
    }

    public function agregarPokemon(Pokemon $pokemon): void
    {
        $this->listaPokemon[] = $pokemon;
    }

    public function buscarPokemonPorNombre(string $nombre): Pokemon
    {
        foreach ($this->listaPokemon as $pokemon) {
            if (strcasecmp($pokemon->getNombre(), $nombre) === 0) {
                return $pokemon;
            }
        }

        throw new PokemonNoEncontradoException("Pokémon {$nombre} no encontrado en la Pokédex.");
    }

    public function guardarCambios(): void
    {
        $pokemonDataList = [];

        foreach ($this->listaPokemon as $pokemon) {
            $pokemonData = [
                'nombre' => $pokemon->getNombre(),
                'tipo' => $pokemon->getTipo(),
                'nivel' => $pokemon->getNivel(),
            ];

            if ($pokemon->getEvolucion()) {
                $pokemonData['evolucion'] = $pokemon->getEvolucion();
            }

            $pokemonDataList[] = $pokemonData;
        }

        $this->database->saveData($pokemonDataList);
    }

    public function existePokemon(string $nombre): bool
    {
        foreach ($this->listaPokemon as $pokemon) {
            if (strcasecmp($pokemon->getNombre(), $nombre) === 0) {
                return true;
            }
        }
        return false;
    }

    public function getListaPokemon(): array
    {
        return $this->listaPokemon;
    }
}
