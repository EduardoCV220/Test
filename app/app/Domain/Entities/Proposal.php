<?php
namespace App\Domain\Entities;

use App\Domain\ValueObjects\Cpf;
use App\Domain\ValueObjects\Money;
use DateTime;

class Proposal{

    private ?int $id;
    private Cpf $cpf;
    private string $nome;
    private string $dataNascimento;
    private Money $valorEmprestimo;
    private string $chavePix;
    private int $autenticado;
    private int $notificado;


    private function __construct($id = null, $cpf, $nome,$dataNascimento, $valorEmprestimo, $chavePix, $autenticado = 0, $notificado = 0){
        $this->id = $id;
        $this->cpf = $cpf;
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->valorEmprestimo = $valorEmprestimo;
        $this->chavePix = $chavePix;
        $this->autenticado = $autenticado;
        $this->notificado = $notificado;
    }

    public static function create(?int $id = null, Cpf $cpf, string $nome, string $dataNascimento, Money $valorEmprestimo, string $chavePix, ?int $autenticado = 0, ?int $notificado = 0){
        return new self($id, $cpf, $nome, $dataNascimento, $valorEmprestimo, $chavePix, $autenticado, $notificado);
    }

        public function nome() :string
    {
        return $this->nome;
    }


    public function id() :int
    {
        return $this->id;
    }

    public function cpf() :Cpf
    {
        return $this->cpf;
    }

    public function data_nascimento() :string
    {
        return $this->dataNascimento;
    }


    public function valor_emprestimo() :Money
    {
        return $this->valorEmprestimo;
    }


    public function chave_pix() :string
    {
        return $this->chavePix;
    }


    public function notificado() :string
    {
        return $this->notificado;
    }



    public function autenticado() :string
    {
        return $this->autenticado;
    }


    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setAutenticado(int $flag) : void
    {
        $this->autenticado = $flag;
    }

        public function setNotificado(int $flag) : void
    {
        $this->autenticado = $flag;
    }
}

?>