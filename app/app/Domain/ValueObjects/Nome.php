<?php

namespace App\Domain\ValueObjects;

use Exception;

class Nome
{
    private string $value;

    public function __construct(string $value)
    {
        $value = trim($value);

        if (!$this->isValid($value)) {
            throw new Exception("Nome inválido");
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function isValid(string $value): bool
    {
        // Verifica se não está vazio
        if (empty($value)) {
            return false;
        }

        // Verifica tamanho mínimo
        if (mb_strlen($value) < 2) {
            return false;
        }

        // Verifica se contém apenas letras e espaços (acentos incluídos)
        if (!preg_match("/^[\p{L} ]+$/u", $value)) {
            return false;
        }

        return true;
    }
}
