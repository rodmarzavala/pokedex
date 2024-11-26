<?php

require_once __DIR__ . '/vendor/autoload.php';

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Utils;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Rodmar\Pokedex\Database\JsonDatabase;

try {
    $database = new JsonDatabase(__DIR__ . '/data/pokemon.json');
    $pokedex = new Pokedex($database);

    // Probamos con Bulbasaur
    $bulbasaur = $pokedex->buscarPokemonPorNombre('Bulbasaur');
    Utils::mostrarInfo($bulbasaur);
    $bulbasaur->subirNivel();
    $bulbasaur->subirNivel();
    $bulbasaur->subirNivel();
    $bulbasaur->evolucionar();
    Utils::mostrarInfo($bulbasaur);

    // Probamos con Magikarp
    $magikarp = $pokedex->buscarPokemonPorNombre('Magikarp');
    Utils::mostrarInfo($magikarp);
    while ($magikarp->getNivel() < 20) {
        $magikarp->subirNivel();
    }
    $magikarp->evolucionar();
    Utils::mostrarInfo($magikarp);

    // Probamos con Mewtwo (no tiene evolución)
    $mewtwo = $pokedex->buscarPokemonPorNombre('Mewtwo');
    Utils::mostrarInfo($mewtwo);
    $mewtwo->evolucionar(); // No debería evolucionar
} catch (PokemonNoEncontradoException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
} catch (\RuntimeException $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
} catch (\JsonException $e) {
    echo 'Error al parsear JSON: ' . $e->getMessage() . PHP_EOL;
}
