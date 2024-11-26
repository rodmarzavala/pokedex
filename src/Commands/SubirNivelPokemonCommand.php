<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Commands;

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Database\JsonDatabase;
use Rodmar\Pokedex\Exceptions\PokemonNoEncontradoException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class SubirNivelPokemonCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('subir-nivel')
            ->setDescription('Sube de nivel a un Pokémon')
            ->addArgument('nombre', InputArgument::REQUIRED, 'Nombre del Pokémon')
            ->addOption('niveles', 'l', InputOption::VALUE_OPTIONAL, 'Cantidad de niveles a subir', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $nombre = $input->getArgument('nombre');
        $niveles = (int) $input->getOption('niveles');

        try {
            $database = new JsonDatabase(__DIR__ . '/../../data/pokemon.json');
            $pokedex = new Pokedex($database);
            $pokemon = $pokedex->buscarPokemonPorNombre($nombre);

            for ($i = 0; $i < $niveles; $i++) {
                $pokemon->subirNivel();
            }

            $pokedex->guardarCambios();

            $io->success("{$pokemon->getNombre()} ha subido {$niveles} nivel(es). Nivel actual: {$pokemon->getNivel()}");

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
