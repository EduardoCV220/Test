<?php

namespace App\Domain\ValueObjects;

use Exception;

class Money
{
    private string $value;

    public function __construct(string $value)
    {
        if (!$this->is_valid($value)) {
            throw new Exception('Valor Invalido');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function is_valid($value): bool
    {
        // Extrai somente os números
        if (!is_numeric($value)) {
            return false;
        }
        else{

      return true;
        }
    }
}