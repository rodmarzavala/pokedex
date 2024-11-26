<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Commands;

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Database\JsonDatabase;
use Rodmar\Pokedex\Utils;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class BuscarPokemonCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('buscar')
            ->setDescription('Busca un Pokémon por su nombre')
            ->addArgument('nombre', InputArgument::REQUIRED, 'Nombre del Pokémon a buscar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nombre = $input->getArgument('nombre');

        try {
            $database = new JsonDatabase(__DIR__ . '/../../data/pokemon.json');
            $pokedex = new Pokedex($database);
            $pokemon = $pokedex->buscarPokemonPorNombre($nombre);

            $io->success("Pokémon encontrado: {$pokemon->getNombre()}");
            $io->section('Información del Pokémon');
            $io->listing([
                "Nombre: " . $pokemon->getNombre(),
                "Tipo: " . $pokemon->getTipo(),
                "Nivel: " . $pokemon->getNivel(),
                "Puede evolucionar: " . ($pokemon->puedeEvolucionar() ? 'Sí' : 'No'),
            ]);

            return Command::SUCCESS;
        } catch (PokemonNoEncontradoException $e) {
            $io->error($e->getMessage());
            return Command::FAILURE;
        } catch (\Exception $e) {
            $io->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
