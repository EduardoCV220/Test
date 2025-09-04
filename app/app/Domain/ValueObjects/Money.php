<?php

namespace App\Domain\ValueObjects;

use Exception;

class Money
{
    private string $value;

    public function __construct(string $value)
    {
        if (!$this->isValid($value)) {
            throw new Exception('Valor Invalido');
        }

        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    private function isValid(string $value): bool
    {
        if (!is_numeric($value)) {
            return false;
        }

        return true;
    }
}
