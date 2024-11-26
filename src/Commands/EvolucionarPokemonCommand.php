<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Commands;

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Database\JsonDatabase;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class EvolucionarPokemonCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('evolucionar')
            ->setDescription('Evoluciona un Pokémon si es posible')
            ->addArgument('nombre', InputArgument::REQUIRED, 'Nombre del Pokémon a evolucionar');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nombre = $input->getArgument('nombre');

        try {
            $database = new JsonDatabase(__DIR__ . '/../../data/pokemon.json');
            $pokedex = new Pokedex($database);
            $pokemon = $pokedex->buscarPokemonPorNombre($nombre);

            if ($pokemon->puedeEvolucionar()) {
                $pokemon->evolucionar();
                $io->success("¡{$pokemon->getNombre()} ha evolucionado!");
            } else {
                $io->warning("{$pokemon->getNombre()} no puede evolucionar en este momento.");
            }

            $pokedex->guardarCambios();

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
