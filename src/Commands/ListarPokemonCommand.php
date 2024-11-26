<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Commands;

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Database\JsonDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ListarPokemonCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('listar')
            ->setDescription('Lista todos los Pokémon en la Pokédex');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $database = new JsonDatabase(__DIR__ . '/../../data/pokemon.json');
            $pokedex = new Pokedex($database);
            $listaPokemon = $pokedex->getListaPokemon();

            if (empty($listaPokemon)) {
                $io->warning('La Pokédex está vacía.');
                return Command::SUCCESS;
            }

            $tableData = [];
            foreach ($listaPokemon as $pokemon) {
                $tableData[] = [
                    $pokemon->getNombre(),
                    $pokemon->getTipo(),
                    $pokemon->getNivel(),
                ];
            }

            $io->title('Lista de Pokémon en la Pokédex');
            $io->table(['Nombre', 'Tipo', 'Nivel'], $tableData);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
