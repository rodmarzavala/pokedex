<?php

declare(strict_types=1);

namespace Rodmar\Pokedex\Commands;

use Rodmar\Pokedex\Pokedex;
use Rodmar\Pokedex\Models\Pokemon;
use Rodmar\Pokedex\Database\JsonDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class AgregarPokemonCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->setName('agregar')
            ->setDescription('Agrega un nuevo Pokémon a la Pokédex');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $helper = $this->getHelper('question');

        try {
            $database = new JsonDatabase(__DIR__ . '/../../data/pokemon.json');
            $pokedex = new Pokedex($database);

            // Solicitar datos al usuario
            $io->title('Agregar un nuevo Pokémon a la Pokédex');

            // Nombre
            $nombreQuestion = new Question('Ingrese el nombre del Pokémon: ');
            $nombre = $helper->ask($input, $output, $nombreQuestion);

            // Verificar si el Pokémon ya existe
            if ($pokedex->existePokemon($nombre)) {
                $io->warning("El Pokémon {$nombre} ya existe en la Pokédex.");
                return Command::SUCCESS;
            }

            // Tipo
            $tipoQuestion = new Question('Ingrese el tipo del Pokémon: ');
            $tipo = $helper->ask($input, $output, $tipoQuestion);

            // Nivel
            $nivelQuestion = new Question('Ingrese el nivel del Pokémon (por defecto 1): ', '1');
            $nivel = (int) $helper->ask($input, $output, $nivelQuestion);

            // Evolución
            $evolucionRespuesta = $io->confirm('¿Este Pokémon tiene una evolución?', false);
            $evolucion = null;

            if ($evolucionRespuesta) {
                $nombreEvolucionQuestion = new Question('Ingrese el nombre de la evolución: ');
                $nombreEvolucion = $helper->ask($input, $output, $nombreEvolucionQuestion);

                $nivelMinimoQuestion = new Question('Ingrese el nivel mínimo para evolucionar: ');
                $nivelMinimo = (int) $helper->ask($input, $output, $nivelMinimoQuestion);

                $evolucion = [
                    'nivel_minimo' => $nivelMinimo,
                    'nombre_evolucion' => $nombreEvolucion,
                ];
            }

            // Crear el nuevo Pokémon
            $nuevoPokemon = new Pokemon($nombre, $tipo, $nivel, $evolucion);

            // Agregar el Pokémon a la Pokédex y guardar cambios
            $pokedex->agregarPokemon($nuevoPokemon);
            $pokedex->guardarCambios();

            $io->success("¡El Pokémon {$nombre} ha sido agregado a la Pokédex!");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $io->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
