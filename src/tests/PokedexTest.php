<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Rodmar\Pokedex\Database\JsonDatabase;

final class PokedexTest extends TestCase
{
    private Pokedex $pokedex;

    protected function setUp(): void
    {
        $database = new JsonDatabase(__DIR__ . '/../data/pokemon.json');
        $this->pokedex = new Pokedex($database);
    }

    public function testBuscarPokemonExistente(): void
    {
        $resultado = $this->pokedex->buscarPokemonPorNombre('Eevee');
        $this->assertSame('Eevee', $resultado->getNombre());
    }

    public function testBuscarPokemonInexistente(): void
    {
        $this->expectException(PokemonNoEncontradoException::class);
        $this->pokedex->buscarPokemonPorNombre('Pidgey');
    }

    public function testEvolucionarPokemonConEvolucion(): void
    {
        $magikarp = $this->pokedex->buscarPokemonPorNombre('Magikarp');
        while ($magikarp->getNivel() < 20) {
            $magikarp->subirNivel();
        }
        $this->assertTrue($magikarp->puedeEvolucionar());
        $magikarp->evolucionar();
        $this->assertSame('Gyarados', $magikarp->getNombre());
    }

    public function testEvolucionarPokemonSinEvolucion(): void
    {
        $onix = $this->pokedex->buscarPokemonPorNombre('Onix');
        $this->assertFalse($onix->puedeEvolucionar());
        $onix->evolucionar();
        $this->assertSame('Onix', $onix->getNombre());
    }
}
