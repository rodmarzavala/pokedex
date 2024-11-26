# Pokédex en PHP

## Descripción
Este proyecto es una Pokédex desarrollada en PHP utilizando Programación Orientada a Objetos (POO) y siguiendo buenas prácticas de desarrollo. La Pokédex permite registrar, actualizar, buscar y evolucionar Pokémon, interactuando con una base de datos en formato JSON y utilizando comandos de consola proporcionados por el componente `symfony/console`.

## Características
- Registro de Pokémon: Agrega nuevos Pokémon a la Pokédex.
- Búsqueda de Pokémon: Busca Pokémon por su nombre y muestra su información.
- Evolución de Pokémon: Evoluciona Pokémon si cumplen con los requisitos.
- Subir de Nivel: Incrementa el nivel de un Pokémon.
- Listado de Pokémon: Muestra todos los Pokémon registrados en la Pokédex.

## Requisitos
- PHP 8.2 o superior
- Composer

## Instalación
1. Clona el repositorio en tu directorio de trabajo.
2. Ejecuta `composer install` para instalar las dependencias.

## Base de datos
La Pokédex utiliza una base de datos en formato JSON para almacenar los Pokémon. La base de datos se encuentra en el archivo `data/pokemon.json`.

## Uso
1. Ejecuta `php pokedex` para iniciar el programa.
2. Utiliza los comandos proporcionados por el componente `symfony/console` para interactuar con la Pokédex.

## Ejemplo de uso

### Agregar Pokémon
Ejecuta el siguiente comando para agregar un nuevo Pokémon a la Pokédex:

```bash
php pokedex agregar
```

Este comando agregará el Pokémon "Bulbasaur" a la Pokédex.

### Buscar Pokémon
Ejecuta el siguiente comando para buscar un Pokémon por su nombre:

```bash
php pokedex buscar Bulbasaur
```

Este comando buscará el Pokémon "Bulbasaur" en la Pokédex y mostrará su información.

### Evolucionar Pokémon
Ejecuta el siguiente comando para evolucionar un Pokémon:

```bash
php pokedex evolucionar Bulbasaur
```

Este comando evolucionará el Pokémon "Bulbasaur" en la Pokédex si cumplen con los requisitos.

### Subir de Nivel
Ejecuta el siguiente comando para subir de nivel un Pokémon:

```bash
php pokedex subir-nivel Bulbasaur --niveles 1
```

Este comando subirá de nivel el Pokémon "Bulbasaur" en la Pokédex.

### Listar Pokémon
Ejecuta el siguiente comando para listar todos los Pokémon en la Pokédex:

```bash
php pokedex listar
```

Este comando listará todos los Pokémon en la Pokédex.

## Licencia
Este proyecto está licenciado bajo la licencia MIT. Puedes encontrar más información sobre la licencia en el archivo `LICENSE`.