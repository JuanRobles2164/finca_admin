<?php

namespace App\Repositories\Factory;

class RepositoryFactory {

    public static function make(string $repositoryClass)
    {
        // Valida si la clase existe y es un repositorio válido
        if (!class_exists($repositoryClass)) {
            throw new \InvalidArgumentException("La clase {$repositoryClass} no existe.");
        }

        return app($repositoryClass); // Usa el contenedor de Laravel para resolver la clase
    }
}
