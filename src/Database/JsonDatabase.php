<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Database;

use JsonException;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use RuntimeException;

final class JsonDatabase
{
    private string $filePath;
    private array $data = [];

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData(): void
    {
        if (!file_exists($this->filePath)) {
            throw new RuntimeException("El archivo {$this->filePath} no existe.");
        }

        $jsonContent = file_get_contents($this->filePath);
        try {
            $this->data = json_decode($jsonContent, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new RuntimeException("Error al parsear JSON: {$e->getMessage()}");
        }
    }

    /**
     * @throws PokemonNoEncontradoException
     */
    public function getPokemonData(string $nombre): array
    {
        foreach ($this->data as $pokemonData) {
            if (strcasecmp($pokemonData['nombre'], $nombre) === 0) {
                return $pokemonData;
            }
        }

        throw new PokemonNoEncontradoException("Pokémon {$nombre} no encontrado en la base de datos.");
    }

    /**
     * @throws JsonException
     */
    public function saveData(array $data): void
    {
        $jsonContent = json_encode($data, JSON_PRETTY_PRINT | JSON_THROW_ON_ERROR);
        file_put_contents($this->filePath, $jsonContent);
    }

    public function getAllPokemon(): array
    {
        return $this->data;
    }
}
